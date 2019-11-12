<?php

class View
{
	private $file;
	private $template;
	private $title;
	private $subtitle;

	public function __construct ($typeView, $action, $side)
	{
		$this->file = 'view/'.$typeView.'/'.$action.'_view.php';
		$this->template = 'template/template_'.$side.'.php';
	}

	public function genView ($datas)
	{
		$content = $this->genFile($this->file, $datas);
		$view = $this->genFile($this->template, array('title' => $this->title, 'subtitle' => $this->subtitle, 'content' => $content));
		echo $view;
	}

	private function genFile($file, $datas)
	{
		if(file_exists($file))
		{
			extract($datas); //tableau associatif contenant éléments de $datas et les rendant accessibles
			ob_start();
			require $file;
			return ob_get_clean();
		}
		else {
			throw new Exception("Le fichier " .$file. " n'existe pas.");
		}
	}
}
