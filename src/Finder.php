
<?php

class Finder {
  /**
   * ! path Must Exist
   * @param path Path of Folder You Want To Search As String
   */
	function __construct($path) {
		$this->path = $path;
	}
  /**
   * @param extension File Extensions That You Want To Find String Or Array
   */
	public function extension($extension) {
		$this->extensions = is_string($extension) ? [$extension] : $extension;
		return $this;
	}
  /**
   * @param exclude File Names That You Want To Ignore
   */
	public function exclude($exclude) {
		$this->exclude = is_string($exclude) ? [$exclude] : $exclude;
		return $this;
	}
  /**
   * @param include File Names That You Want To Find
   */
	public function include($include) {
		$this->include = is_string($include) ? [$include] : $include;
		return $this;
	}
  /**
   * @param contain Check File Contain This Value
   */
	public function contain($contain) {
		$this->contain = trim(strval($contain));
		return $this;
	}
  /**
   * @param date Timestamp That You Want To Check
   * @param operation Any Math Operator +,-,*,/
   */
	public function date($date, $operation) {
		$this->date = $date;
		$this->operation = $operation;
		return $this;
	}

	public function delete() {
		$files = $this->list()->files ?? [];
		$deleted = 0;
		foreach ($files as $file) $deleted = $deleted + ( unlink($file) ? 1 : 0);
		return $deleted;
	}

	private function list() {
		if(!file_exists($this->path)) return "File Or Directory Is Not Exist";
		$include = $this->include ?? NULL;
		$exclude = $this->exclude ?? NULL;
		$directory = new RecursiveDirectoryIterator($this->path, RecursiveDirectoryIterator::SKIP_DOTS);
		$filter = new RecursiveCallbackFilterIterator($directory, function ($current, $key, $iterator) use($include, $exclude) {
			if ($iterator->hasChildren()) return true;
			if (is_array($include)) return $current->isFile() && in_array($current->getFilename(), $include);
			if (is_array($exclude)) return $current->isFile() && !in_array($current->getFilename(), $exclude);
			return true;
		});
		$iterator = new RecursiveIteratorIterator($filter);
		$files = array();
		foreach ($iterator as $info ) {
			$path = $info->getPathname();
			$created = $info->getCTime();
			if((isset($this->extensions) && !in_array($info->getExtension(), $this->extensions)) || (($this->contain ?? false) && strpos(file_get_contents($path), $this->contain) === false) ) continue;
			if (isset($this->date) && isset($this->operation) && in_array($this->operation,['<','>','!=','==','<=','>=']) && $info->isFile()) {
				if (eval("return $created $this->operation $this->date;")) $files[] = $path;
				continue;
			}
			$files[] = $path;
		}
		$this->files = $files;
		return $this;
	}

	public function get() {
		return $this->list()->files ?? [];
	}
}