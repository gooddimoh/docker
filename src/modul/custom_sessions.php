<?php

class CustomSessions
{
    const STATUS_INIT = 1;
    const STATUS_NOT_INIT = 0;
    const STATUS_CLOSE_WRITE = 2;
    const STATUS_OPEN_WRITE = 3;
    const STATUS_ERROR_START = 4;

    private static $status = self::STATUS_NOT_INIT;

    private static $fileHandle = null;
    private static $sid = null;

    private static $name = 'studsid';
    private static $maxlifetime = 1440;
    private static $gc_maxlifetime = 1620;

    //private static $maxlifetime = 30; //test
    //private static $gc_maxlifetime = 60; //test

    private static $dir = 'sessions';

    public static function start()
    {
        try
        {
            if(self::$status == self::STATUS_CLOSE_WRITE)
                return;

            if(self::$status == self::STATUS_NOT_INIT)
                self::init();

            if(self::$sid && self::checkSid(self::$sid))
                self::OpenSession(self::$dir . '/' . self::$sid);
            else
                self::CreateSession();

            self::Lock();
            self::ReadSession();

            setcookie(self::$name, self::$sid, time() + self::$maxlifetime, '/', null, false, true);
        }
        catch(Exception $e)
        {
            $msg = sprintf('%s in %s on line %d. exception --->', $e->getMessage(), $e->getFile(), $e->getLine());
            error_log($msg, E_ERROR);

            if(self::$sid)
                setcookie(self::$name, '', 1, '/', null, false, true);

            header('HTTP/1.1 503 Service Temporarily Unavailable');
            header('Status: 503 Service Temporarily Unavailable');
            header('Retry-After: 300');

            self::setStatus(self::STATUS_ERROR_START);
            die();
        }
    }

    private static function OpenSession($fileName)
    {
        self::$fileHandle = fopen($fileName, 'r+');
        if(self::$fileHandle === false)
            throw new Exception('Error open session file');
    }

    private static function CreateSession()
    {
        for($j = 0; $j < 100000; $j++)
        {
            self::$sid = self::generateSid();
            self::$fileHandle = @fopen(self::$dir . '/' . self::$sid, 'x+');
            if(self::$fileHandle !== false)
                return;
        }

        throw new Exception('Cannot create session file');
    }

    private static function ReadSession()
    {
        $size = filesize(self::$dir . '/' . self::$sid);
        if(!$size)
        {
            $_SESSION = array();
            return;
        }

        $data = fread(self::$fileHandle, $size);
        if($data === false)
            throw new Exception('Error read session');

        $_SESSION = json_decode($data, true);

        if(!is_array($_SESSION))
        {
            $_SESSION = array();
            error_log('Error format session data', E_WARNING);
        }
    }

    private static function WriteSession()
    {
        $data = json_encode(is_array($_SESSION) ? $_SESSION : array());

        if(!ftruncate(self::$fileHandle, 0))
            throw new Exception('Error clear session file');

        if(!rewind(self::$fileHandle))
            throw new Exception('Error rewind session file');

        if(fwrite(self::$fileHandle, $data) === false)
            throw new Exception('Error write session file');

        if(!fflush(self::$fileHandle))
            throw new Exception('Error flush session file');
    }

    private static function Lock()
    {
        if(!flock(self::$fileHandle, LOCK_EX))
            throw new Exception('Error file lock session file');

        self::setStatus(self::STATUS_CLOSE_WRITE);
    }

    private static function Unlock()
    {
        if(!flock(self::$fileHandle, LOCK_UN))
            throw new Exception('Error file unlock session file');

        self::setStatus(self::STATUS_OPEN_WRITE);
    }

    private static function init()
    {
        self::$dir = $_SERVER["DOCUMENT_ROOT"] . '/' . self::$dir;

        if(!file_exists(self::$dir) || !is_dir(self::$dir))
            throw new Exception('Session directory "' . self::$dir . '" not found');

        self::$sid = isset($_COOKIE[self::$name]) ? preg_replace('/[^A-z0-9]/', '', $_COOKIE[self::$name]) : false;
        self::gc();
        self::setStatus(self::STATUS_INIT);
    }

    private static function checkSid($sid)
    {
        $endTime = time() - self::$maxlifetime;
        return file_exists(self::$dir . '/' . $sid) && filemtime(self::$dir . '/' . $sid) > $endTime;
    }

    private static function setStatus($status)
    {
        self::$status = $status;
    }

    private static function gc()
    {
        $endTime = time() - self::$gc_maxlifetime;

        foreach(scandir(self::$dir) as $name)
        {
            if($name == '.' || $name == '..' || $name == '.htaccess')
                continue;

            if(filemtime(self::$dir . '/' . $name) < $endTime)
                unlink(self::$dir . '/' . $name);
        }
    }

    public static function id()
    {
        return self::$sid;
    }

    public static function name()
    {
        return self::$name;
    }

    public static function write_close()
    {
        if(self::$status !== self::STATUS_CLOSE_WRITE)
            return;

        self::WriteSession();
        self::Unlock();
        fclose(self::$fileHandle);
        self::$fileHandle = null;
    }

    private function generateSid()
    {
        $rnd = mcrypt_create_iv(32, MCRYPT_DEV_URANDOM);
        if($rnd === false)
            throw new Exception('Error generate sid');

        return hash('sha256', $rnd);
    }
}

register_shutdown_function(array('CustomSessions', 'write_close'));
