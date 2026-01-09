<?php

namespace App\Helpers;

class AnalyticsHelper
{
    protected static $filePath;

    // Retorna o caminho do ficheiro JSON de analytics
    protected static function getFilePath()
    {
        if (!self::$filePath) {
            self::$filePath = storage_path('app/analytics.json');
        }
        return self::$filePath;
    }

    // Lê os dados do ficheiro analytics.json
    protected static function readData()
    {
        $file = self::getFilePath();
        
        if (!file_exists($file)) {
            file_put_contents($file, json_encode([]));
            return [];
        }
        
        return json_decode(file_get_contents($file), true) ?? [];
    }

    // Escreve dados no ficheiro analytics.json
    protected static function writeData($data)
    {
        file_put_contents(self::getFilePath(), json_encode($data, JSON_PRETTY_PRINT));
    }

    // Regista login de utilizador
    public static function trackLogin($userId, $userName)
    {
        $data = self::readData();
        
        $data[] = [
            'user_id' => $userId,
            'name' => $userName,
            'type' => 'login',
            'timestamp' => now()->toDateTimeString(),
        ];
        
        self::writeData($data);
    }

    // Regista pesquisa feita por utilizador
    public static function trackSearch($userId, $userName, $query = null)
    {
        $data = self::readData();
        
        $data[] = [
            'user_id' => $userId,
            'name' => $userName,
            'type' => 'search',
            'query' => $query,
            'timestamp' => now()->toDateTimeString(),
        ];
        
        self::writeData($data);
    }

    // Regista comentário adicionado por utilizador
    public static function trackComment($userId, $userName)
    {
        $data = self::readData();
        
        $data[] = [
            'user_id' => $userId,
            'name' => $userName,
            'type' => 'comment',
            'timestamp' => now()->toDateTimeString(),
        ];
        
        self::writeData($data);
    }

    // Regista tempo passado por utilizador na aplicação
    public static function trackTime($userId, $userName, $duration)
    {
        $data = self::readData();
        
        $data[] = [
            'user_id' => $userId,
            'name' => $userName,
            'type' => 'time',
            'duration' => $duration,
            'timestamp' => now()->toDateTimeString(),
        ];
        
        self::writeData($data);
    }
}
