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

        public function getView(string $identifier, string $layout = ""): void {
            if($layout === "") {
                $this->getTemplate($identifier);
            }
            else {
                $this->getLayout($identifier, $layout);
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

        public function getTemplate(string $identifier): void {
            $this->cache->freeCache();
            $cache = $this->cache->locateCache($identifier);
            if($cache['status']) {
                $hasChanged = $this->watcher->hasFileChanged($identifier, $cache['path']);
                if($hasChanged) {
                    echo "Recompiled Successfully";       
                    $code = $this->compile($identifier);
                    $this->cache($identifier, $code);
                    $this->render($identifier);  
                }
                elseif(!$hasChanged) {
                    echo "No Changes";
                    $this->render($identifier);  
                }
            }
            elseif(!$cache['status']) {
                echo "No Cache";
                $code = $this->compile($identifier);
                $this->cache($identifier, $code);
                $this->render($identifier);   
            }
        }

        public function getLayout(string $identifier, string $layout): void {
            $this->cache->freeCache();
            $cache = $this->cache->locateCache($identifier);
            if($cache['status']) {
                $hasChanged = $this->watcher->hasFileChanged($identifier, $cache['path']);
                $hasLayoutChanged = $this->watcher->hasLayoutChanged($layout, $cache['path']);
                if($hasChanged || $hasLayoutChanged) {
                    echo "Recompiled Successfully";
                    $code = $this->compiler->compileWithLayout($identifier, $layout);
                    $this->cache($identifier, $code);
                    $this->render($identifier);  
                }
                elseif(!$hasChanged || !$hasLayoutChanged) {
                    echo "No Changes";
                    $this->render($identifier);  
                }
            }
            elseif(!$cache['status']) {
                echo "No Cache";
                $code = $this->compiler->compileWithLayout($identifier, $layout);
                $this->cache($identifier, $code);
                $this->render($identifier);   
            }
        }

    }