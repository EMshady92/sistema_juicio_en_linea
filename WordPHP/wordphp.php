<?php namespace WordPHP;

use ZipArchive;
use DOMDocument;
use XMLReader;

class WordPHP
{
	private $debug = false;
	private $file;
	private $rels_xml;
	private $doc_xml;
	private $doc_media = [];
	private $last = 'none';
	private $encoding = 'ISO-8859-1';
	private $tmpDir = 'tmp';
	
	/**
	 * CONSTRUCTOR
	 * 
	 * @param Boolean $debug Debug mode or not
	 * @return void
	 */
	public function __construct($debug_=null, $encoding=null)
	{
		if($debug_ != null) {
			$this->debug = $debug_;
		}
		if ($encoding != null) {
			$this->encoding = $encoding;
		}
		$this->tmpDir = dirname(__FILE__);
	}

	/**
	 * Sets the tmp directory where images will be stored
	 * 
	 * @param string $tmp The location 
	 * @return void
	 */
	private function setTmpDir($tmp)
	{
		$this->tmpDir = $tmp;
	}

	/**
	 * READS The Document and Relationships into separated XML files
	 * 
	 * @param var $object The class variable to set as DOMDocument 
	 * @param var $xml The xml file
	 * @param string $encoding The encoding to be used
	 * @return void
	 */
	private function setXmlParts(&$object, $xml, $encoding)
	{
		$object = new DOMDocument();
		$object->encoding = $encoding;
		$object->preserveWhiteSpace = false;
		$object->formatOutput = true;
		$object->loadXML($xml);
		$object->saveXML();
	}

	/**
	 * READS The Document and Relationships into separated XML files
	 * 
	 * @param String $filename The filename
	 * @return void
	 */
	private function readZipPart($filename)
	{ 
		$zip = new ZipArchive();
		$_xml = 'word/document.xml';
		$_xml_rels = 'word/_rels/document.xml.rels';
		
		if (true === $zip->open($filename)) {
			if (($index = $zip->locateName($_xml)) !== false) {
				$xml = $zip->getFromIndex($index);
			}
			//Get the relationships
			if (($index = $zip->locateName($_xml_rels)) !== false) {
				$xml_rels = $zip->getFromIndex($index);
			}
			// load all images if they exist
			for ($i=0; $i<$zip->numFiles;$i++) {
            	$zip_element = $zip->statIndex($i);
            	 if(preg_match("([^\s]+(\.(?i)(jpg|jpeg|png|gif|bmp))$)",$zip_element['name'])) {
            	 	$this->doc_media[$zip_element['name']] = $zip_element['name'];
            	 }
        	}
			$zip->close();
		} else die('non zip file');

		$enc = mb_detect_encoding($xml);
		$this->setXmlParts($this->doc_xml, $xml, $enc);
		$this->setXmlParts($this->rels_xml, $xml_rels, $enc);
		
		if($this->debug) {
			echo "<textarea style='width:100%; height: 200px;'>";
			echo $this->doc_xml->saveXML();
			echo "</textarea>";
			echo "<textarea style='width:100%; height: 200px;'>";
			echo $this->rels_xml->saveXML();
			echo "</textarea>";
		}
	}

	/**
	 * CHECKS THE FONT FORMATTING OF A GIVEN ELEMENT
	 * Currently checks and formats: bold, italic, underline, background color and font family
	 * 
	 * @param XML $xml The XML node
	 * @return String HTML formatted code
	 */
	private function checkFormating(&$xml)
	{	
		$node = trim($xml->readOuterXML());
		$t = '';
		// add <br> tags
		if (strstr($node,'<w:br ')) $t = '<br>';					 
		// look for formatting tags
		$f = "<span style='";
		$reader = new XMLReader();
		$reader->XML($node);
		$img = null;

		while ($reader->read()) {
			if($reader->name == "w:b") {
				$f .= "font-weight: bold,";
			}
			if($reader->name == "w:i") {
				$f .= "text-decoration: underline,";
			}
			if($reader->name == "w:color") {
				$f .="color: #".$reader->getAttribute("w:val").",";
			}
			if($reader->name == "w:rFont") {
				$f .="font-family: #".$reader->getAttribute("w:ascii").",";
			}
			if($reader->name == "w:shd" && $reader->getAttribute("w:val") != "clear" && $reader->getAttribute("w:fill") != "000000") {
				$f .="background-color: #".$reader->getAttribute("w:fill").",";
			}
			if($reader->name == 'w:drawing' && !empty($reader->readInnerXml())) {
				$r = $this->checkImageFormating($reader);
				$img = $r !== null ? "<image src='".$r."' />" : null;
			}
		}
		
		$f = rtrim($f, ',');
		$f .= "'>";
		$t .= ($img !== null ? $img : htmlentities($xml->expand()->textContent));

		return $f.$t."</span>";
	}
	
	/**
	 * CHECKS THE ELEMENT FOR UL ELEMENTS
	 * Currently under development
	 * 
	 * @param XML $xml The XML node
	 * @return String HTML formatted code
	 */
	private function getListFormating(&$xml)
	{	
		$node = trim($xml->readOuterXML());
		
		$reader = new XMLReader();
		$reader->XML($node);
		$ret="";
		$close = "";		
		while ($reader->read()){
			if($reader->name == "w:numPr" && $reader->nodeType == XMLReader::ELEMENT ) {
				
			}
			if($reader->name == "w:numId" && $reader->hasAttributes) {
				switch($reader->getAttribute("w:val")) {					
					case 1:
					//	$ret['open'] = "<ol><li>";
					//	$ret['close'] = "</li></ol>";
					//	break;
					case 2:
					//	$ret['open'] = "<ul><li>";
					//	$ret['close'] = "</li></ul>";
					//	break;
				}
				
			}
		}
		return $ret;
	}
	
	/**
	 * CHECKS IF THERE IS AN IMAGE PRESENT
	 * Currently under development
	 * 
	 * @param XML $xml The XML node
	 * @return String The location of the image
	 */
	private function checkImageFormating(&$xml)
	{
		$content = trim($xml->readInnerXml());

		if (!empty($content)) {

			$relId;
			$notfound = true;
			$reader = new XMLReader();
			$reader->XML($content);
			
			while ($reader->read() && $notfound) {
				if ($reader->name == "a:blip") {
					$relId = $reader->getAttribute("r:embed");
					$notfound = false;
				}
			}

			// image id found, get the image location
			if (!$notfound && $relId) {
				$reader = new XMLReader();
				$reader->XML($this->rels_xml->saveXML());
				
				while ($reader->read()) {
					if ($reader->nodeType == XMLREADER::ELEMENT && $reader->name=='Relationship') {
						if($reader->getAttribute("Id") == $relId) {
							$link = "word/".$reader->getAttribute('Target');
							break;
						}
					}
				}

    			$zip = new ZipArchive();
    			$im = null;
    			if (true === $zip->open($this->file)) {
        			$im = $this->createImage($zip->getFromName($link), $relId, $link);
    			}
    			$zip->close();
    			return $im;
			}
		}

		return null;
	}

	/**
	 * Creates an image in the filesystem
	 *  
	 * @param objetc $image The image object
	 * @param string $relId The image relationship Id
	 * @param string $name The image name
	 * @return Array With HTML open and closing tag definition
	 */
	private function createImage($image, $relId, $name)
	{
		$arr = explode('.', $name);
		$l = count($arr);
		$ext = strtolower($arr[$l-1]);

		$im = imagecreatefromstring($image);
		//$fname = $this->tmpDir.'/tmp/'.$relId.'.'.$ext;
		$fname = '../WordPHP/tmp/'.$relId.'.'.$ext;

		switch ($ext) {
			case 'png':
				imagepng($im, $fname);
				break;
			case 'bmp':
				imagebmp($im, $fname);
				break;
			case 'gif':
				imagegif($im, $fname);
				break;
			case 'jpeg':
			case 'jpg':
				imagejpeg($im, $fname);
				break;
			default:
				return null;
		}

		return $fname;
	}

	/**
	 * CHECKS IF ELEMENT IS AN HYPERLINK
	 *  
	 * @param XML $xml The XML node
	 * @return Array With HTML open and closing tag definition
	 */
	private function getHyperlink(&$xml)
	{
		$ret = array('open'=>'<ul>','close'=>'</ul>');
		$link ='';
		if($xml->hasAttributes) {
			$attribute = "";
			while($xml->moveToNextAttribute()) {
				if($xml->name == "r:id")
					$attribute = $xml->value;
			}
			
			if($attribute != "") {
				$reader = new XMLReader();
				$reader->XML($this->rels_xml->saveXML());
				
				while ($reader->read()) {
					if ($reader->nodeType == XMLREADER::ELEMENT && $reader->name=='Relationship') {
						if($reader->getAttribute("Id") == $attribute) {
							$link = $reader->getAttribute('Target');
							break;
						}
					}
				}
			}
		}
		
		if($link != "") {
			$ret['open'] = "<a href='".$link."' target='_blank'>";
			$ret['close'] = "</a>";
		}
		
		return $ret;
	}


	/**
	 * PROCESS TABLE CONTENT
	 *  
	 * @param XML $xml The XML node
	 * @return THe HTML code of the table
	 */
	private function checkTableFormating(&$xml)
	{
		$table = "<table><tbody>";

		while ($xml->read()) {
			if ($xml->nodeType == XMLREADER::ELEMENT && $xml->name === 'w:tr') { //table row
				$tc = $ts = "";


				$tr = new XMLReader;
				$tr->xml(trim($xml->readOuterXML()));

				while ($tr->read()) {
					if ($tr->nodeType == XMLREADER::ELEMENT && $tr->name === 'w:tcPr') { //table element properties
						$ts = $this->processTableStyle(trim($tr->readOuterXML()));
					}
					if ($tr->nodeType == XMLREADER::ELEMENT && $tr->name === 'w:tc') { //table column
						$tc .= $this->processTableRow(trim($tr->readOuterXML()));
					}
				}
				$table .= '<tr style="'.$ts.'">'.$tc.'</tr>';
			}
		}

		$table .= "</tbody></table>";
		return $table;
	}

	/**
	 * PROCESS THE TABLE ROW STYLE
	 *  
	 * @param string $content The XML node content
	 * @return THe HTML code of the table
	 */
	private function processTableStyle($content)
	{
		/*border-collapse:collapse; 
		border-bottom:4px dashed #0000FF; 
		border-top:6px double #FF0000; 
		border-left:5px solid #00FF00; 
		border-right:5px solid #666666;*/

		$tc = new XMLReader;
		$tc->xml($content);
		$style = "border-collapse:collapse;";

		while ($tc->read()) {
			if ($tc->name === "w:tcBorders") {
				$tc2 = new SimpleXMLElement($tc->readOuterXML());

				foreach ($tc2->children('w',true) as $ch) {
					if (in_array($ch->getName(), ['left','top','botom','right']) ) {
						$line = $this->convertLine($ch['val']);
						$style .= " border-".$ch->getName().":".$ch['sz']."px $line #".$ch['color'].";";
					}
				}
				
				$tc->next();
			}
		}
		return $style;
	}

	private function convertLine($in)
	{
		if (in_array($in, ['dotted']))
			return "dashed";

		if (in_array($in, ['dotDash','dotdotDash','dotted','dashDotStroked','dashed','dashSmallGap']))
			return "dashed";
		
		if (in_array($in, ['double','triple','threeDEmboss','threeDEngrave','thick']))
			return "double";

		if (in_array($in, ['nil','none']))
			return "none";

		return "solid";
	}

	/**
	 * PROCESS THE TABLE ROW
	 *  
	 * @param string $content The XML node content
	 * @return THe HTML code of the table
	 */
	private function processTableRow($content)
	{
		$tc = new XMLReader;
		$tc->xml($content);
		$ct = "";

		while ($tc->read()) {
			if ($tc->name === "w:r") {
				$ct .= "<td>".$this->checkFormating($tc)."</td>";
				$tc->next();
			}
		}
		return $ct;
	}

	/**
	 * READS THE GIVEN DOCX FILE INTO HTML FORMAT
	 *  
	 * @param String $filename The DOCX file name
	 * @return String With HTML code
	 */
	public function readDocument($filename)
	{
		$this->file = $filename;
		$this->readZipPart($filename);
		$reader = new XMLReader();
		$reader->XML($this->doc_xml->saveXML());

		$text = ''; $list_format="";

		$formatting['header'] = 0;
		// loop through docx xml dom
		while ($reader->read()) {
		// look for new paragraphs
			$paragraph = new XMLReader;
			$p = $reader->readOuterXML();

			if ($reader->nodeType == XMLREADER::ELEMENT && $reader->name === 'w:p') {
				// set up new instance of XMLReader for parsing paragraph independantly				
				$paragraph->xml($p);

				preg_match('/<w:pStyle w:val="(Heading.*?[1-6])"/',$p,$matches);
				if(isset($matches[1])) {
					switch($matches[1]){
						case 'Heading1': $formatting['header'] = 1; break;
						case 'Heading2': $formatting['header'] = 2; break;
						case 'Heading3': $formatting['header'] = 3; break;
						case 'Heading4': $formatting['header'] = 4; break;
						case 'Heading5': $formatting['header'] = 5; break;
						case 'Heading6': $formatting['header'] = 6; break;
						default: $formatting['header'] = 0; break;
					}
				}
				// open h-tag or paragraph
				$text .= ($formatting['header'] > 0) ? '<h'.$formatting['header'].'>' : '<p>';
				
				// loop through paragraph dom
				while ($paragraph->read()) {
					// look for elements
					if ($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:r') {
						if($list_format == "")
							$text .= $this->checkFormating($paragraph);
						else {
							$text .= $list_format['open'];
							$text .= $this->checkFormating($paragraph);
							$text .= $list_format['close'];
						}
						$list_format ="";
						$paragraph->next();
					}
					else if($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:pPr') { //lists
						$list_format = $this->getListFormating($paragraph);
						$paragraph->next();
					}
					else if($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:drawing') { //images
						$text .= $this->checkImageFormating($paragraph);
						$paragraph->next();
					}
					else if ($paragraph->nodeType == XMLREADER::ELEMENT && $paragraph->name === 'w:hyperlink') {
						$hyperlink = $this->getHyperlink($paragraph);
						$text .= $hyperlink['open'];
						$text .= $this->checkFormating($paragraph);
						$text .= $hyperlink['close'];
						$paragraph->next();
					}
				}
				$text .= ($formatting['header'] > 0) ? '</h'.$formatting['header'].'>' : '</p>';
			}
			else if ($reader->nodeType == XMLREADER::ELEMENT && $reader->name === 'w:tbl') { //tables
				$paragraph->xml($p);
				$text .= $this->checkTableFormating($paragraph);
				$reader->next();
			}
		}
		$reader->close();
		if($this->debug) {
			echo "<div style='width:100%; height: 200px;'>";
			echo mb_convert_encoding($text, $this->encoding);
			echo "</div>";
		}
		return mb_convert_encoding($text, $this->encoding);
	}
}
