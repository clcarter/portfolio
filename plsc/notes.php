
<?php require_once 'inc/header.php';

$sort = !empty($_GET)?$_GET['q']: -1;
$view = new SortFiles();

?>
	<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css">
<div id="TabbedPanels1" class="TabbedPanels">
	<ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab" tabindex="0">Author</li>
		<li class="TabbedPanelsTab" tabindex="1">Topic</li>
		<li class="TabbedPanelsTab" tabindex="2">Day</li>
	</ul>
	<div class="TabbedPanelsContentGroup">
		<div class="TabbedPanelsContent"><?php print $view->Author(); ?></div>
		<div class="TabbedPanelsContent"><?php print $view->Topic(); ?></div>
		<div class="TabbedPanelsContent"><?php print $view->Day(); ?></div>
	</div>
</div>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1",{defaultTab: <?php print $sort > -1 ? $sort : 0; ?>});
</script>
	
	
	
	


<?php  require_once 'inc/footer.php'; 



/**
* Sort Files
*/
class SortFiles{	
	
	public function Author(){
		return $this->fileGetter(2);
	}
	public function Topic(){
		return $this->fileGetter(1);
	}
	
	public function Day(){
		return $this->fileGetter(0);
	}
	public function All(){
		return $this->fileGetter();	
	}
	
	private function fileGetter($s = -1){
		$my_sort = array();
		$dir = 'mat/pdf';
 		//$t = new CachingIterator(new Extension_Filter(new DirectoryIterator($dir)));
		if ($handle = @opendir($dir)) {
    	//	echo "Directory handle: $handle\n";
   	//	echo "Entries:\n";

    /* This is the correct way to loop over the directory. */
   		while (false !== ($entry = @readdir($handle))) {
        	//	echo "$entry\n";
		  
				if($entry !== '.' && $entry !== '..' && $entry !== '_notes'){
			
					$name = explode('_',$entry);
					if($s == 2){
						$name[2] = explode('.',end($name));
						$name[2] = $name[2][0];
					}
					elseif($s==0){
						$date = explode('-',$name[0]);
						$date = implode('/',$date);
						$date = date('l, F d',strtotime($date));
						$name[0]=$date;
					}
			
					if($s>-1){
						$my_sort[$entry] = $name[$s];
					}
					else{
						$my_sort[$entry] = 'All';
					}
				}
			}
			closedir($handle);
			
			//print_r($my_sort);
			natsort($my_sort);
//			$same = false;
			$content = array();
			$prev = '';
			foreach($my_sort as $key => $val){
				if($prev != $val){
					$content[$val] = new ContentSection($val);
					$prev = $val;
				}
				$content[$val]->addElement($key, $dir);
			}
			$html='';
			foreach($content as $el){
				$html .= $el->getSection();
			}
			
			return $html;

		}
		
	
	
	}

}

	class Extension_Filter extends FilterIterator {
	  public function accept() {
        return $this->current()->isFile() && preg_match("/\.(pub|pptx?|docx?|pdf|xlsx?|do|log)$/i", $this->current()->getBasename());
   	}
	}
	
class ContentSection{
	private $title;
	private $elements = array();
	
	public function __construct($title=''){
		$this->setTitle($title);
	}
	
	public function setTitle($title){
		$this->title = "<legend class='enderTitle'>".$title."</legend>";
	}

	public function addElement($element,$dir){
		$html = "<a href='$dir/$element'>$element</a><br />";
		array_push($this->elements, $html);
	}
	public function removeElement($key){
		unset($this->elements[$key]);
	}
	public function getSection(){
		return $this->setSection();
	}
	public function setSection(){
		$html = "
		<fieldset class='enderContent'>
			".$this->title."<p>";
		
		foreach($this->elements as $element){
			$html.=$element;
		}

			
		$html.="</p></fieldset>";
		return $html;
	}
}

?>