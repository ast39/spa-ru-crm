<?php


namespace App\Http\Services;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Illuminate\Support\Facades\File;

class ApiTg {

    const SIZE_LIMIT_TEXT = 'is too big for a';

    /**
     * Информация о боте и клиенте
     *
     * @return array
     */
    public static function getMe(): array
    {
        try {
            $response = Telegram::getMe();

            return self::getResultData([
                'bot_id'     => $response->getId,
                'first_name' => $response->getFirstName,
                'user_name'  => $response->getUsername,
            ]);

        } catch (\Exception $e) {

            return self::getErrorData($e);
        }
    }

    /**
     * Получить файл
     *
     * @param string $file_id
     * @return array
     * @throws TelegramSDKException
     */
    public static function getFile(string $file_id): array
    {
        $file = Telegram::getFile([
            'file_id' => $file_id
        ]);

        return [

            'file_id' => $file->fileId,
            'uuid'    => $file->fileUniqueId,
            'size'    => $file->fileSize,
            'path'    => $file->filePath,
            'all'     => $file,
        ];

    }

    /**
     * Сохранить файл
     *
     * @param string $path
     * @param string $folder
     * @return string
     */
    public static function saveUserFile(string $path, string $folder = '')
    {
        $extension = explode('.', $path);
        $extension = $extension[count($extension) - 1];

        $filename = date('my').'_'.time().'.'.$extension;
        $folder = 'tmp/'.date('my').'/'.(($folder != '')? $folder.'/' : '');

        if(!File::exists(public_path($folder))){
            File::makeDirectory(public_path($folder), 0777, true, true);
        }

        copy('https://api.telegram.org/file/bot' . config('telegram.bots.mybot.token') . '/' . $path, public_path($folder.$filename));

        return $folder.$filename;
    }

    /**
     * Аватарки юзера
     *
     * @param int $user_id
     * @return array
     * @throws TelegramSDKException
     */
    public static function getUserAvatar(int $user_id): array
    {
        $avatar = Telegram::getUserProfilePhotos([
            'user_id' => $user_id
        ]);

        return $avatar->photos;
    }

    /**
     * Получить обновления
     *
     * @param int $offset
     * @param int $limit
     * @param int $timeout
     * @return array
     */
    public static function getUpdates(int $offset = 0, int $limit = 100, int $timeout = 0): array
    {
        try {
            $response = Telegram::getUpdates([
                'offset'  => $offset,
                'limit'   => $limit,
                'timeout' => $timeout,
            ]);

            return self::getResultData($response);

        } catch (\Exception $e) {

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка простого сообщения
     *
     * @param int $chat_id
     * @param string $message
     * @param bool $disable_notification // Беззвучное сообщение
     * @return array
     */
    public static function sendMessage(int $chat_id, string $message,  bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendMessage([

                'chat_id'              => $chat_id,
                'text'                 => $message,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка сообщения с кнопками
     *
     * @param int $chat_id
     * @param string $message
     * @param $reply_markup
     * @param bool $disable_notification // Беззвучное сообщение
     * @return array
     */
    public static function sendMessageVsButtons(int $chat_id, string $message,  $reply_markup, bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendMessage([

                'chat_id'              => $chat_id,
                'text'                 => $message,
                'disable_notification' => $disable_notification,
                'reply_markup'         => $reply_markup
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка изображения
     *
     * @param int $chat_id
     * @param string $image
     * @param string $caption // подпись к фото
     * @param bool $disable_notification // Беззвучное сообщение
     * @return array
     */
    public static function sendImage(int $chat_id, $image, string $caption = '',  bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendPhoto([

                'chat_id'              => $chat_id,
                'photo'                => fopen($image, 'r'),
                'caption'              => $caption,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            if (stripos($e->getMessage(), self::SIZE_LIMIT_TEXT) !== null) {
                return self::sendFile($chat_id, $image, $caption, $disable_notification);
            }

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка аудио
     *
     * @param int $chat_id
     * @param string $audio
     * @param string $caption
     * @param bool $disable_notification
     * @return array
     */
    public static function sendAudio(int $chat_id, string $audio, string $caption = '', bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendAudio([
                'chat_id'              => $chat_id,
                'audio'                => InputFile::create($audio, 'Audio'),
                'caption'              => $caption,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            if (stripos($e->getMessage(), self::SIZE_LIMIT_TEXT) !== null) {
                return self::sendFile($chat_id, $audio, $caption, $disable_notification);
            }

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка голосового сообщения
     *
     * @param int $chat_id
     * @param string $audio
     * @param string $caption
     * @param bool $disable_notification
     * @return array
     */
    public static function sendVoice(int $chat_id, string $audio, string $caption = '', bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendAudio([
                'chat_id'              => $chat_id,
                'voice'                => InputFile::create($audio, 'Voice'),
                'caption'              => $caption,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            if (stripos($e->getMessage(), self::SIZE_LIMIT_TEXT) !== null) {
                return self::sendFile($chat_id, $audio, $caption, $disable_notification);
            }

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка видео
     *
     * @param int $chat_id
     * @param string $video
     * @param string $caption
     * @param bool $disable_notification
     * @return array
     */
    public static function sendVideo(int $chat_id, string $video, string $caption = '', bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendVideo([
                'chat_id'              => $chat_id,
                'video'                => InputFile::create($video),
                'caption'              => $caption,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            if (stripos($e->getMessage(), self::SIZE_LIMIT_TEXT) !== null) {
                return self::sendFile($chat_id, $video, $caption, $disable_notification);
            }

            return self::getErrorData($e);
        }
    }

    /**
     * Отправка файла
     *
     * @param int $chat_id
     * @param string $file
     * @param string $caption
     * @param bool $disable_notification
     * @return array
     */
    public static function sendFile(int $chat_id, string $file, string $caption = '', bool $disable_notification = false): array
    {
        try {
            $response = Telegram::sendDocument([
                'chat_id'              => $chat_id,
                'document'             => InputFile::create($file),
                'caption'              => $caption,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            return self::getErrorData($e);
        }
    }

    /**
     * Пересылка сообщения
     *
     * @param int $chat_id
     * @param int $from_chat_id
     * @param int $message_id
     * @param bool $disable_notification // Беззвучное сообщение
     * @return array
     */
    public static function forwardMessage(int $chat_id, int $from_chat_id, int $message_id, bool $disable_notification = false): array
    {
        try {
            $response = Telegram::forwardMessage([

                'chat_id'              => $chat_id,
                'from_chat_id'         => $from_chat_id,
                'message_id'           => $message_id,
                'disable_notification' => $disable_notification,
            ]);

            return self::getResultData($response->getMessageId());

        } catch (\Exception $e) {

            return self::getErrorData($e);
        }
    }

    /**
     * Формат успешного ответа
     *
     * @param $response
     * @return array[]
     */
    protected static function getResultData($response): array
    {
        return [
            'result' => $response
        ];
    }

    /**
     * Формат ответа ошибки
     *
     * @param $e
     * @return array[]
     */
    protected static function getErrorData($e): array
    {
        return [
            'error' => [
                'code' => $e->getCode(),
                'msg'  => $e->getMessage(),
            ],
        ];
    }
}
