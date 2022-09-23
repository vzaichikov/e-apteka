<?php
	class Document {
		private $title;
		private $description;
		private $canonical;
		private $keywords;
		private $robots_meta;
		//	private $noindex = false;
		private $og_image;
		private $hreflangs = array();
		private $links = array();
		private $styles = array();
		private $scripts = array();
		private $opengraph = array();
		
		
		public function setTitle($title) {
			$this->title = $title;
		}
		
		public function getTitle() {
			return $this->title;
		}
		
		public function setDescription($description) {
			$this->description = $description;
		}
		
		public function getDescription() {
			return $this->description;
		}
		
		public function setKeywords($keywords) {
			$this->keywords = $keywords;
		}
		
		public function getKeywords() {
			return $this->keywords;
		}
		
		public function setRobotsMeta($content){
			$this->robots_meta = $content;		
		}
		
		public function getRobotsMeta(){
			return $this->robots_meta;
		}
		
				
		public function getOpengraph() {
			return $this->opengraph;
		}
		
		public function addLink($href, $rel) {			
			$this->links[$href.' '.$rel] = array(
			'href' => $href,
			'rel'  => $rel
			);
		}
		
		public function setOpengraph($meta, $content) {
			$this->opengraph[] = array(
			'meta'   => $meta,
			'content' => $content
			);
		}
		
		public function addLinkCanonical($href, $rel) {
			if ($rel == 'canonical'){
				$this->setCanonical($href);
				} else {
				$this->links[$href] = array(
				'href' => $href,
				'rel'  => $rel
				);
			}
		}
		
		// OCFilter start
		public function setNoindex($state = false) {
			$this->noindex = $state;
		}
		
		public function isNoindex() {
			return $this->noindex;
		}
		// OCFilter end
		
		// OCFilter canonical fix start
		public function deleteLink($rel) {
			foreach ($this->links as $href => $link) {
				if ($link['rel'] == $rel) {
					unset($this->links[$href]);
				}
			}
		}
		// OCFilter canonical fix end
		
		public function getLinks() {
			return $this->links;
		}
		
		public function addHrefLang($hreflang, $href) {
			$this->hreflangs[$href] = array(
			'hreflang' => $hreflang,
			'href'  => $href
			);
		}
		
		public function getHrefLangs() {
			return $this->hreflangs;
		}
		
		public function setCanonical($canonical) {
			$this->canonical = $canonical;
		}
		public function getCanonical() {
			return $this->canonical;
		}
		
		public function addStyle($href, $rel = 'stylesheet', $media = 'screen') {
			
			if (stripos($href, '?v=')){
				$version = explode("?v=",$href);
				$href = $version[0];
			}
			
			if (stripos($href, '?v')){
				$version = explode("?v",$href);
				$href = $version[0];
			}
			
			$this->styles[$href] = array(
			'href'  => $href,
			'rel'   => $rel,
			'media' => $media
			);
		}
		
		public function getStyles() {
			return $this->styles;
		}
		
		public function setOgImage($image) {
			$this->og_image = $image;
		}
		public function getOgImage() {
			return $this->og_image;
		}
		
		public function addScript($href, $postion = 'header') {
			
			if (stripos($href, '?v=')){
				$version = explode("?v=",$href);
				$href = $version[0];
			}
			
			$this->scripts[$postion][$href] = $href;
		}
		
		public function getScripts($postion = 'header') {
			if (isset($this->scripts[$postion])) {
				return $this->scripts[$postion];
				} else {
				return array();
			}
		}
	}						