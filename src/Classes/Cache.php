<?php

    namespace Templater\Classes;

    use Templater\Exceptions\CachingException;

    class Cache {

        public string $cacheDir;

        public function __construct(string $cachePath = "templater") {
            $this->cacheDir = $this->createCacheDir($cachePath);
        }

        private function createCacheDir(string $cachePath): string {
            if($cachePath === "") {
                $dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'cache';
            }
            else {
                $dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$cachePath.DIRECTORY_SEPARATOR.'cache';
            }
            if(!is_dir($dir))
            {
                mkdir($dir, 0777, true);
            }

            return $dir;
        }

        public function cacheFile(string $identifier, string $code): void {
            $identifier = str_replace(".php", "", $identifier);
            $cacheId = hash("sha256", $identifier);
            try {
                $file = fopen($this->cacheDir.DIRECTORY_SEPARATOR.$cacheId.".php", "w+");
                fwrite($file, $code);
                fclose($file);
            } catch (CachingException $th) {
                throw new CachingException();
            }
        
        }

        public function locateCache(string $identifier): array {
            if (is_dir($this->cacheDir)) {

                $path = $this->cacheDir.DIRECTORY_SEPARATOR."*.php";

                $files = glob($path);

                $hashed_id = hash("sha256", $identifier);

                foreach ($files as $file) {
                    $filepath = $file;
                    $file = explode(DIRECTORY_SEPARATOR, $file);
                    $file = $file[count($file) - 1];
                    $file = str_replace(".php", "", $file);
                    if($hashed_id === $file) {
                        $cacheInfo = ["path" => $filepath, "modificationTime" => filemtime($filepath), "status" => true];
                        return $cacheInfo;
                    }    
                }

                return ["path" => "", "modificationTime" => 0, "status" => false];
            }
        }

        public function freeCache(int $cacheExpiration = 3600): void {
            if (is_dir($this->cacheDir)) {

                $path = $this->cacheDir.DIRECTORY_SEPARATOR."*.php";

                $files = glob($path);

                foreach ($files as $file) {
                    $currentTime = time();
                    $cacheModificationTime = filemtime($file);
                    if(($currentTime - $cacheModificationTime) > $cacheExpiration) {
                        unlink($file);
                    }
                }
            }
        }
    }