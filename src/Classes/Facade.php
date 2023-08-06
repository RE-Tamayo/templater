<?php

    namespace Templater\Classes;

    use Templater\Classes\Compiler;
    use Templater\Classes\Cache;
    use Templater\Classes\Renderer;
    use Templater\Classes\Watcher;

    class Facade {
        private Compiler $compiler;
        private Cache $cache;
        private Renderer $renderer;
        private Watcher $watcher;

        public function __construct() {
            $this->renderer = new Renderer();
            $this->compiler = new Compiler($this->renderer->templatesDir);
            $this->cache = new Cache();
            $this->watcher = new Watcher($this->renderer->templatesDir);
        }

        public function getView(string $identifier): void {
            //FREE CACHE
            $this->cache->freeCache();
            //CHECK IF CACHE EXISTS
            $cache = $this->cache->locateCache($identifier);
            if($cache['status']) {
                //IF EXISTS
                    //CHECK FOR CHANGES
                    $hasChanged = $this->watcher->hasFileChanged($identifier, $cache['path']);
                    if($hasChanged) {
                        echo "Recompiled Successfully";
                        //IF CHANGES
                            //RECOMPILE
                            $code = $this->compile($identifier);
                            $this->cache($identifier, $code);
                            //RENDER
                            $this->render($identifier);  
                    }
                    elseif(!$hasChanged) {
                        echo "No Changes";
                        //IF NO CHANGES
                            //RENDER
                            $this->render($identifier);  
                    }
            }
            elseif(!$cache['status']) {
                echo "No Cache";
                //IF NOT
                    //CREATE CACHE
                    $code = $this->compile($identifier);
                    $this->cache($identifier, $code);
                    $this->render($identifier);   
            }
        }

        private function compile(string $identifier): string {
            $code = $this->compiler->compile($identifier); 
            return $code;   
        }

        private function cache(string $identifier, string $code): void {
            $this->cache->cacheFile($identifier, $code);
        }

        private function render(string $identifier): void {
            $this->renderer->render($this->cache->locateCache($identifier)['path']);
        }

    }