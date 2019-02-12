<?php

final class Cache {

    private $expire;
    private $memcache;
    private $ismemcache = false;

    public function __construct($exp = 259200) {
        $this->expire = $exp;
        
        if (CACHE_DRIVER == 'memcached') {
            $mc = new Memcache;

            if ($mc->pconnect(MEMCACHE_HOSTNAME, MEMCACHE_PORT)) {
                $this->memcache = $mc;
                $this->ismemcache = true;
            };
        };
        
        $files = glob(DIR_CACHE . 'cache.*');
        
        if ($files) {
            foreach ($files as $file) {
                $time = substr(strrchr($file, '.'), 1);

                if ($time < time()) {
                    if (file_exists($file)) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    public function get($key) {
        if ((CACHE_DRIVER == 'memcached') && $this->ismemcache) {
            return($this->memcache->get(MEMCACHE_NAMESPACE . $key, 0));
        } else {
            $files = glob(DIR_CACHE . 'cache.' . $key . '.*');

            if ($files) {
                foreach ($files as $file) {
                    $cache = '';

                    $handle = fopen($file, 'r');

                    if ($handle) {
                        $cache = fread($handle, filesize($file));

                        fclose($handle);
                    }

                    return unserialize($cache);
                }
            }
        }

        return false;
    }

    public function set($key, $value) {
        if ((CACHE_DRIVER == 'memcached') && $this->ismemcache) {
            $this->memcache->set(MEMCACHE_NAMESPACE . $key, $value, MEMCACHE_COMPRESSED, $this->expire);
        } else {
            $this->delete($key);

            $file = DIR_CACHE . 'cache.' . $key . '.' . (time() + $this->expire);

            $handle = fopen($file, 'w');

            fwrite($handle, serialize($value));
            fclose($handle);
        }
    }

    public function delete($key) {
        if ((CACHE_DRIVER == 'memcached') && $this->ismemcache) {
            $this->memcache->delete(MEMCACHE_NAMESPACE . $key, 0);
        } else {
            $files = glob(DIR_CACHE . 'cache.' . $key . '.*');

            if ($files) {
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        @unlink($file);
                        clearstatcache();
                    }
                }
            }
        }
    }
}

