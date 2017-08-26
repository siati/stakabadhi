<?php

namespace common\models;

use Yii;
use DateTime;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use ZipArchive;

/**
 * more static functions
 */
class StaticMethods {

    const firm_root_folder = 'documents';
    const regular_folder = 'first';
    const archive_folder = 'second';
    const recycle_folder = 'third';
    const regular_name = 'documents';
    const archive_name = 'archive';
    const recycle_name = 'recycle';
    const downloads_folder = 'downloads';
    const slides_folder = 'slides';
    const mail_zips_folder = 'mailzips';
    const versions_folder = 'versions';
    const uploads_folder = 'uploads';
    const file_extensions_folder = 'doc-icons';
    const min_root_document_level = 0;
    const min_sub_root_document_level = 1;
    const min_client_document_level = 2;
    const dir_recursive = true;
    const dir_unrecursive = false;
    const folders_only = 0;
    const files_only = 1;
    const files_and_folders = 2;
    const directory_list = 0;
    const directory_tree = 1;
    const array_key = true;
    const array_val = false;
    const long = 'long';
    const longer = 'longer';
    const longest = 'longest';
    const short = 'short';
    const file_not_found = 'file not found';
    const file_rejected = 'file rejected';
    const file_upload_not_reach_server = 'uploaded file did not reach the server';
    const file_deny = 'deny';
    const file_read = 'read';
    const file_write = 'write';
    const file_alter = 'alter';
    const ext_name = 'name';
    const ext_type = 'type';
    const ext_icon = 'icon';
    const ext_folder = 'folder';
    const ext_is_dir = 'r';
    const ext_is_doc = 'f';
    const ext_is_exl = 'x';
    const ext_is_pdf = 'd';
    const ext_is_img = 'i';
    const ext_is_vde = 'v';
    const ext_is_msc = 'm';
    const ext_is_ppt = 'p';
    const ext_is_cde = 'c';
    const ext_is_dbs = 'b';
    const ext_is_unknown = 'u';
    const connection_failed = 'connection failed';
    const sent = 'sent';
    const not_sent = 'failed';
    const cat1 = '1';
    const cat2 = '2';
    const cat3 = '3';
    const cat4 = '4';
    const form_one = '1';
    const form_two = '2';
    const form_three = '3';
    const form_four = '4';
    const term_one = '1';
    const term_two = '2';
    const term_three = '3';
    const grade = 'grade';
    const name = 'name';
    const points = 'points';
    const symbol = 'symbol';
    const irregularity = 'Y';
    const missed = 'X';
    const code = 'code';
    const dept = 'dept';
    const lang = 'lang';
    const scnc = 'scnc';
    const hmnt = 'hmnt';
    const tcnl = 'tcnl';
    const level = 'level';
    const primary = 'primary';
    const secondary = 'secondary';
    const primary_and_secondary = 'both';

    /**
     * 
     * @return string location of documents root folder
     */
    public static function rootFolderHardCode() {
        $ex = explode(DIRECTORY_SEPARATOR, Yii::$app->basePath);

        $ex[count($ex) - 1] = self::firm_root_folder;

        return implode(DIRECTORY_SEPARATOR, $ex) . '/';
    }

    /**
     * 
     * @return string root document path
     */
    public static function dirRoot() {
        return Yii::$app->basePath . '/../' . self::firm_root_folder . '/';
    }

    /**
     * 
     * @return string root document link
     */
    public static function dirRootUrl() {
        return Yii::$app->homeUrl . '../../' . self::firm_root_folder . '/';
    }

    /**
     * 
     * @return string location of downloads root folder
     */
    public static function downloadsFolderHardCode() {
        $ex = explode(DIRECTORY_SEPARATOR, Yii::$app->basePath);

        $ex[count($ex) - 1] = self::downloads_folder;

        return implode(DIRECTORY_SEPARATOR, $ex) . '/';
    }

    /**
     * 
     * @return string root download path
     */
    public static function downloadsFolder() {
        return Yii::$app->basePath . '/../' . self::downloads_folder . '/';
    }

    /**
     * 
     * @return string root download link
     */
    public static function downloadsFolderUrl() {
        return Yii::$app->homeUrl . '../../' . self::downloads_folder . '/';
    }

    /**
     * 
     * @return string root download path
     */
    public static function slidesFolder() {
        return Yii::$app->basePath . '/../' . self::slides_folder . '/';
    }

    /**
     * 
     * @return string root download link
     */
    public static function slidesFolderUrl() {
        return Yii::$app->homeUrl . '../../' . self::slides_folder . '/';
    }

    /**
     * 
     * @return string location of mail zips root folder
     */
    public static function mailZipsFolderHardCode() {
        $ex = explode(DIRECTORY_SEPARATOR, Yii::$app->basePath);

        $ex[count($ex) - 1] = self::mail_zips_folder;

        return implode(DIRECTORY_SEPARATOR, $ex) . '/';
    }

    /**
     * 
     * @return string root mail zips link
     */
    public static function mailZipsFolderUrl() {
        return Yii::$app->homeUrl . '../../' . self::mail_zips_folder . '/';
    }

    /**
     * 
     * @return string root mail zips path
     */
    public static function mailZipsFolder() {
        return Yii::$app->basePath . '/../' . self::mail_zips_folder . '/';
    }

    /**
     * 
     * @return string location of document versions root folder
     */
    public static function versionsFolderHardCode() {
        $ex = explode(DIRECTORY_SEPARATOR, Yii::$app->basePath);

        $ex[count($ex) - 1] = self::versions_folder;

        return implode(DIRECTORY_SEPARATOR, $ex) . '/';
    }

    /**
     * 
     * @return string root document versions link
     */
    public static function versionsFolderUrl() {
        return Yii::$app->homeUrl . '../../' . self::versions_folder . '/';
    }

    /**
     * 
     * @return string root document versions path
     */
    public static function versionsFolder() {
        return Yii::$app->basePath . '/../' . self::versions_folder . '/';
    }

    /**
     * 
     * @return string location of uploads root folder
     */
    public static function uploadsFolderHardCode() {
        $ex = explode(DIRECTORY_SEPARATOR, Yii::$app->basePath);

        $ex[count($ex) - 1] = self::uploads_folder;

        return implode(DIRECTORY_SEPARATOR, $ex) . '/';
    }

    /**
     * 
     * @return string root uploads link
     */
    public static function uploadsFolderUrl() {
        return Yii::$app->homeUrl . '../../' . self::uploads_folder . '/';
    }

    /**
     * 
     * @return string root uploads path
     */
    public static function uploadsFolder() {
        return Yii::$app->basePath . '/../' . self::uploads_folder . '/';
    }

    /**
     * 
     * @return string root extension icons link
     */
    public static function extensionIconsFolderUrl() {
        return Yii::$app->homeUrl . '../../common/assets/icons/' . self::file_extensions_folder . '/';
    }

    /**
     * 
     * @return string root extension icons path
     */
    public static function extensionIconsFolder() {
        return Yii::$app->basePath . '/../' . self::file_extensions_folder . '/';
    }

    /**
     * 
     * @param string $subDir directory name
     * @return string directory location
     */
    public static function dirSubRoot($subDir) {
        return static::dirRoot() . "$subDir/";
    }

    /**
     * 
     * @param string $subDir directory name
     * @return string directory link
     */
    public static function dirSubRootUrl($subDir) {
        return static::dirRootUrl() . "$subDir/";
    }

    /**
     * 
     * @return array main subdirectory names under the institution root directory
     */
    public static function rootSubDirs() {
        return [self::regular_folder, self::archive_folder, self::recycle_folder];
    }

    /**
     * 
     * @param integer $level level of file
     * @return boolean true - is a root folder or sub-folder
     */
    public static function isRootOrSubRootFolder($level) {
        return in_array($level, [self::min_root_document_level, self::min_sub_root_document_level]);
    }

    /**
     * 
     * @param string $string string to alt directory separator
     * @param string $replace separator to replace
     * @return string with alt-ed directory separator
     */
    public static function altDirSeparator($string, $replace) {
        $ds = DIRECTORY_SEPARATOR;

        $altDs = '/';

        return str_replace($replace, $replace == $ds ? $altDs : $ds, $string);
    }

    /**
     * 
     * @param string $string unformated paragraph
     * @return string formatted paragraph
     */
    public static function paragraphCase($string) {

        $previousPreviousLetter = $previousLetter = $newString = '';

        for ($x = 0; $x < strlen($string); $x++) {

            if (($letter = ($upper = $newString == '' && ctype_alnum(substr($string, $x, 1))) || $newString != '' ? substr($string, $x, 1) : '') != '')
                if (ctype_alpha($letter))
                    if ($upper || in_array($previousLetter, ["\n", "\r"]) || ($previousLetter == ' ' && (in_array($previousPreviousLetter, ['.', '?', '!']) || ctype_upper($letter))))
                        $newString .= strtoupper($letter);
                    else
                        $newString .= strtolower($letter);
                else
                    $newString .= $letter;

            $previousPreviousLetter = $previousLetter;

            $previousLetter = $letter;
        }

        return $newString;
    }

    /**
     * 
     * @param string $file_name file location
     * @param string $dir_name directory location
     * @return boolean true - file is contained in directory
     */
    public static function fileIsInDirectory($file_name, $dir_name) {
        return stripos($file_name, $dir_name) === 0;
    }

    /**
     * 
     * @param string $dir directory location
     * @param boolean $recursive true - recursive
     * @param integer $type type of files desired : 0 - folders, 1 - files, 2 - both
     * @param integer $listOrTree 0 - directory file list, 1 - directory tree
     * @param array $files pre-parsed files
     * @return array desired files
     */
    public static function dirRecursor($dir, $recursive, $type, $listOrTree, $selected, $files) {

        $tree = $listOrTree == self::directory_tree;

        $directoryFiles = scandir($dir);

        foreach ($directoryFiles as $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);

            if (($type == self::files_and_folders || ($type == self::folders_only && is_dir($path)) || ($type == self::files_only && !is_dir($path))))
                if (!is_dir($path))
                    $files[] = $path;
                else
                if ($value != '.' && $value != '..') {
                    $tree ? $files[$path] = [] : $files[$path] = $path;

                    if ((empty($selected) || self::fileIsInDirectory($selected, $path)) && $recursive == self::dir_recursive) {
                        $loadedFiles = static::dirRecursor($path, $recursive, $type, $listOrTree, $selected, []);

                        $tree ? $files[$path] += $loadedFiles : $files += $loadedFiles;
                    }
                }
        }

        return $files;
    }

    /**
     * 
     * @param array $array elements to order
     * @param array $order custom order array
     * @return array $array elements ordered
     */
    public static function arrayCustomSort($array, $order) {

        usort($array, function ($a, $b) use ($order) {
            return array_search($a, $order) - array_search($b, $order);
        });

        return $array;
    }

    /**
     * 
     * @param array $array elements to order
     * @param array $order custom order array
     * @return array $array elements ordered
     */
    public static function arrayCustomSortFolders($array, $order) {

        usort($array, function ($a, $b) use ($order) {
            return array_search(basename($a), $order) - array_search(basename($b), $order);
        });

        return $array;
    }

    /**
     * 
     * every element here must be described in `function fileTypeDescription()` below
     * 
     * @return array acceptable file types
     */
    public static function acceptableFileTypes() {
        return ['doc', 'docx', 'xls', 'xlsx', 'pdf', 'ppt', 'pps', 'pptx', 'csv', 'jpg', 'jpeg', 'png', 'bmp', 'gif', 'mp3', 'mp4', 'flv', 'dat'];
    }

    /**
     * 
     * @return string json format of `acceptableFileTypes()`
     */
    public static function implodeAcceptableFileTypes() {
        return static::arrayImplode(static::acceptableFileTypes(), ',');
    }

    /**
     * every element in `function acceptableFileTypes()` above  must be described here
     * 
     * @param string $type file extension
     * @return array description of file `$type`
     */
    public static function fileTypeDescription($type) {
        $extensions = [
            'doc' => $desc = [self::ext_name => 'Word Document', self::ext_type => self::ext_is_doc, self::ext_icon => 'doc.png'],
            'docx' => $desc,
            'xls' => $desc = [self::ext_name => 'Excel Workbook', self::ext_type => self::ext_is_exl, self::ext_icon => 'sheet.png'],
            'xlsx' => $desc,
            'pdf' => [self::ext_name => 'PDF File', self::ext_type => self::ext_is_pdf, self::ext_icon => 'pdf.png'],
            'ppt' => $desc = [self::ext_name => 'Presentation File', self::ext_type => self::ext_is_ppt, self::ext_icon => 'presentation.png'],
            'pps' => $desc,
            'pptx' => $desc,
            'csv' => [self::ext_name => 'Excel Worksheet', self::ext_type => self::ext_is_exl, self::ext_icon => 'sheet.png'],
            'jpg' => $desc = [self::ext_name => 'Image File', self::ext_type => self::ext_is_img, self::ext_icon => 'image.png'],
            'jpeg' => $desc,
            'png' => $desc,
            'bmp' => $desc,
            'gif' => $desc,
            'mp3' => $desc = [self::ext_name => 'Music File', self::ext_type => self::ext_is_msc, self::ext_icon => 'music.png'],
            'mp4' => $desc = [self::ext_name => 'Video File', self::ext_type => self::ext_is_vde, self::ext_icon => 'video.png'],
            'flv' => $desc,
            'dat' => $desc,
            self::ext_folder => $desc = [self::ext_name => 'Directory', self::ext_type => self::ext_is_dir, self::ext_icon => 'folder.png'],
            'unknown' => $desc = [self::ext_name => 'Unknown', self::ext_type => self::ext_is_unknown, self::ext_icon => 'file.png'],
        ];

        return $extensions[empty($extensions[$type]) ? 'unknown' : $type];
    }

    /**
     * @param string $extension file extension
     * @param boolean $location true - return icon location, else icon url
     * @return string icon location or url
     */
    public static function documentVersionIcon($extension, $location) {
        return ($location ? static::extensionIconsFolder() : static::extensionIconsFolderUrl()) . static::fileTypeDescription($extension)[static::ext_icon];
    }

    /**
     * @param string $extension file extension
     * @return string icon location or url
     */
    public static function documentType($extension) {
        return static::fileTypeDescription($extension)[static::ext_name];
    }

    /**
     * 
     * @param string $fileName file name
     * @return boolean true - file type acceptable
     */
    public static function fileTypeAllowed($fileName) {
        $explode = explode('.', $fileName);
        return in_array(strtolower(end($explode)), self::acceptableFileTypes());
    }

    /**
     * 
     * @param ActiveRecord $model model
     * @param string $attribute attribute of model
     * @param UploadedFile $file uploaded file
     * @param string $directory root directory in which to save `$file`
     * @param string $folder folder in which to save `$file`
     * @param string $filename file name
     * @param string $folder attribute of Files object class
     */
    public static function saveUploadedFile($model, $attribute, $file, $directory, $folder, $filename) {
        !empty($file) && self::fileTypeAllowed($file->name) && ($model->$attribute = $file) && $model->validate([$attribute]) && $file->saveAs($directory . ($saveAs = strtolower(("$folder/$filename." . (strtolower($file->extension)))))) ?
                        ($model->$attribute = $saveAs) : (empty($file) ? '' : $model->addError($attribute, "$file->name not uploaded"));
    }

    /**
     * 
     * @param string $filename file name
     * @return string file in containing folder (all uploads are in uploads), or url not found
     */
    public static function fileExists($filename) {
        return !empty($filename) && file_exists(self::dirRoot() . "$filename") ? $filename : self::file_not_found;
    }

    /**
     * 
     * @param string $filename file name
     * @return boolean true - file unlinked
     */
    public static function fileUnlink($filename) {
        return !is_file(self::dirRoot() . "$filename") || @unlink(self::dirRoot() . "$filename");
    }

    /**
     * 
     * @param string $directory directory name
     * @return boolean true - directory removed
     */
    public static function removeDirectory($directory) {
        return !is_dir(self::dirRoot() . "$directory") || @rmdir(self::dirRoot() . "$directory");
    }

    /**
     * 
     * @param string $filename file name
     * @return string url to file
     */
    public static function fileDownload($filename) {
        copy($location = self::dirRoot() . $filename, self::downloadsFolder() . ($location = basename($location)));
        Downloads::downloadToLoad(Yii::$app->user->identity->id, $location);
        return self::downloadsFolderUrl() . $location;
    }

    /**
     * 
     * @param array $files files to archive
     * @return array url to the zip folder created and contained files
     */
    public static function zipAndDownload($files) {
        $return = self::zipFiles($files);

        $return[0] == '' || empty($return[0]) ? ('') : ($return[0] = self::downloadsFolderUrl() . $return[0]);

        return $return;
    }

    /**
     * 
     * @param array $files files to archive
     * @return array location of the zip folder created and contained files
     */
    public static function zipAndLoad($files) {
        $return = self::zipFiles($files);

        $return[0] == '' || empty($return[0]) ? ('') : ($return[0] = self::downloadsFolder() . $return[0]);

        return $return;
    }

    /**
     * 
     * @param array $files files to archive
     * @return array location of the created zip folder and contained files
     */
    public static function zipFiles($files) {
        $zip = new ZipArchive();

        $zip->open($chuja = self::downloadsFolder() . ($location = self::stripNonNumeric(self::now()) . '.zip'), ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $names = [];

        $detail_delimiter = DocumentsMailings::detail_delimiter;

        foreach ($files as $file)
            if (is_file($file[0])) {
                $explode = explode('.', $file[0]);

                $nameCounts = array_count_values($names);

                $name = "$file[1]." . ($ext = end($explode));

                empty($nameCounts[$name]) ? '' : $name = "$file[1] $nameCounts[$name].$ext";

                if ($zip->addFile($file[0], $name)) {
                    $desc = (empty($desc) ? '' : "$desc,") . "$file[2]$detail_delimiter$name";
                    array_push($names, $name);
                }
            }

        $zip->close();

        empty($names) ? @unlink($chuja) : Downloads::downloadToLoad(Yii::$app->user->identity->id, $location);

        return [empty($names) ? '' : $location, empty($desc) ? '' : $desc];
    }

    /**
     * 
     * @param string $fileLink hyperlink to the downloaded / exported file
     * @return boolean true - file removed
     */
    public static function dropExportedFile($fileLink) {
        return @unlink(static::downloadsFolderHardCode() . str_replace(self::downloads_folder . '/', '', substr($fileLink, stripos($fileLink, self::downloads_folder))));
    }

    /**
     * 
     * @param string $path file location
     * @param string $string string to find
     * @param boolean $all true - read through whole file
     * @return boolean|array true - string found in file
     */
    public static function searchFileContent($path, $string, $all) {
        $matches = array();

        $handle = @fopen($path, 'r');
        if ($handle) {

            while (!feof($handle)) {
                $buffer = fgets($handle);

                if (stripos($buffer, $string) !== false)
                    if ($all)
                        $matches[] = $buffer;
                    else {
                        fclose($handle);
                        return true;
                    }
            }

            fclose($handle);
        }
    }

    /**
     * 
     * @return array months
     */
    public static function months() {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];
    }

    /**
     * 
     * @param integer $month month: 1 - 12
     * @param integer $year year yyyy
     * @return integer max date 28 - 31
     */
    public function monthMaxDate($month, $year) {
        return in_array($month * 1, [1, 3, 5, 7, 8, 10, 12]) ? (31) : ($month * 1 != 2 ? (30) : ($year % 4 == 0 ? 29 : 28));
    }

    /**
     * 
     * @param string $date yyyy-mm-dd
     * @return string month name
     */
    public static function monthForDate($date) {

        $monthName = self::months()[$month = substr($date, 5, 2) * 1];

        return empty($monthName) ? $month : $monthName;
    }

    /**
     * 
     * @param string $date yyyy-mm-dd
     * @param string $monthHow short / long
     * @return string Jan 01, 2016
     */
    public static function dateString($date, $monthHow) {
        return strlen($date) > 9 ? (($monthHow == self::short ? (substr(self::monthForDate($date), 0, 3)) : (
                ($monthHow == self::long ? ('') : (date($monthHow == self::longest ? 'l' : 'D', strtotime($date)) . ' ')) . self::monthForDate($date))
                ) . ' ' . substr($date, 8, 2) . ', ' . substr($date, 0, 4)) : ('NULL');
    }

    /**
     * 
     * @param array $models models
     * @param string $key attribute of each of the [[$models]]
     * @param string $value value of
     * @return array extracted associative array
     */
    public static function modelsToArray($models, $key, $value) {
        return ArrayHelper::map($models, $key, $value);
    }

    /**
     * populate a dropdown using given array
     * 
     * @param array $array simple or associative array
     * @param string $prompt prompt
     * @param string $selected selected
     */
    public static function populateDropDown($array, $prompt, $selected) {
        if (!empty($prompt))
            echo "<option " . ($selected == '' || $selected == null ? "selected='selected' " : '') . "value=''>-- $prompt --</option>";

        foreach ($array as $key => $value)
            echo "<option " . ($key == $selected ? "selected='selected' " : '') . "value='$key'>$value</option>";
    }

    /**
     * 
     * @return string yyyy-mm-dd
     */
    public static function today() {
        return date('Y-m-d');
    }

    /**
     * 
     * @return string current time to micro seconds
     */
    public static function now() {
        $t = microtime(true);

        $micro = sprintf('%06d', ($t - floor($t)) * 1000000);

        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));

        return $d->format('Y-m-d H:i:s.u');
    }

    /**
     * 
     * @param string $dateTime date
     * @return boolean true - time empty
     */
    public static function timeEmpty($dateTime) {
        return empty($dateTime) || self::stripNonNumeric($dateTime) == 0;
    }

    /**
     * 
     * @param string $date date
     * @return boolean true `$date` is date
     */
    public static function isDate($date) {
        try {
            list($y, $m, $d) = explode('-', $date);
        } catch (\Exception $ex) {
            list($y, $m, $d) = [0, 0, 0];
        }

        return checkdate($m, $d, $y);
    }

    /**
     * 
     * @param string $date date yyyy-mm-dd hh:mm:ss
     * @param integer|double $days interval days
     * @return string final date
     */
    public static function dateAddDays($date, $days) {
        $since = date_create($date);

        date_add($since, date_interval_create_from_date_string("$days days"));

        return date_format($since, 'Y-m-d H:i:s');
    }

    /**
     * 
     * @param string $date date yyyy-mm-dd hh:mm:ss
     * @param integer|double $days interval days
     * @return string final date
     */
    public static function dateSubTractDays($date, $days) {
        $since = date_create($date);

        date_sub($since, date_interval_create_from_date_string("$days days"));

        return date_format($since, 'Y-m-d H:i:s');
    }

    /*
     * remove non-numeric characters from a string.
     */

    public static function stripNonNumeric($str) {
        return preg_replace('(\D+)', '', $str);
    }

    /**
     * 
     * @param string $string string
     * @param string $delimiter string
     * @return array
     */
    public static function stringExplode($string, $delimiter) {
        return explode($delimiter, $string);
    }

    /**
     * 
     * @param array $pieces pieces / elements
     * @param string $glue
     * @return string final string
     */
    public static function arrayImplode($pieces, $glue) {
        return implode($glue, $pieces);
    }

    /**
     * 
     * @param integer $size file size
     * @return array converted size and units
     */
    public static function fileSizeConverter($size) {
        if ($size < 1000)
            return [$size, 'B'];

        if ($size < 1000000)
            return [ceil($size / 1024), 'KB'];

        if ($size < 1000000000)
            return [ceil($size / (1024 * 1024)), 'MB'];

        if ($size < 1000000000000)
            return [ceil($size / (1024 * 1024 * 1024)), 'GB'];

        if ($size < 1000000000000)
            return [ceil($size / (1024 * 1024 * 1024 * 1024)), 'TB'];

        return [ceil($size / (1024 * 1024 * 1024 * 1024 * 1024)), 'PB'];
    }

    /**
     * 
     * @param string $html_view mail html view
     * @param string $text_view mail text view
     * @param array $mail parameter for the mail views
     * @param array $from sender - [email => name]
     * @param array $to primary recipients - [email1 => name1, email2 => name2]
     * @param array $cc secondary recipients - [email1 => name1, email2 => name2]
     * @param array $bcc tertiary recipients - [email1 => name1, email2 => name2]
     * @param string $subject subject of email
     * @param array $attachments file locations
     * @return array|boolean true -sent, false - not sent, array - connection fail exception
     */
    public static function sendMail($html_view, $text_view, $mail, $from, $to, $cc, $bcc, $subject, $attachments) {
        try {
            $mailer = Yii::$app->mailer->compose(['html' => $html_view, 'text' => $text_view], $mail);

            $mailer->setFrom($from)->setTo($to)->setCc($cc)->setBcc($bcc)->setSubject($subject);

            if (is_array($attachments))
                foreach ($attachments as $attachment)
                    $mailer->attach($attachment);

            return $mailer->send();
        } catch (\Exception $ex) {
            return [substr($ex, 0, 100), self::connection_failed];
        }
    }

    /**
     * 
     * @param string $target_url target url / endpoint
     * @param array $post parameters being parsed via post
     * @return string|boolean success or failure message
     */
    public static function seekService($target_url, $post) {
        is_object($auth = AuthKey::loadKey(null)) ? $post['auth_key'] = $auth->auth_key : '';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, static::buildQueryForCurl($post));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: multipart/form-data']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * 
     * @param array $post post values in array form
     * @return array formatted post values
     */
    public static function buildQueryForCurl($post) {
        foreach ($post as $className => $attributes)
            if (is_array($attributes))
                foreach ($attributes as $attribute => $values)
                    if (is_array($values))
                        foreach ($values as $index => $value)
                            $thePost["$className" . "[$attribute][$index]"] = $value;
                    else
                        $thePost["$className" . "[$attribute]"] = $values;
            else
                $thePost["$className"] = $attributes;

        return empty($thePost) ? [] : $thePost;
    }

    /**
     * 
     * @return array school levels - primary, secondary
     */
    public static function schoolLevels() {
        return [
            $val = self::primary => ucfirst($val),
            $val = self::secondary => ucfirst($val),
            $val = self::primary_and_secondary => ucfirst($val)
        ];
    }

    /**
     * @param string $level primary or secondary
     * @return array terms
     */
    public static function terms($level) {
        return $level == self::primary || $level == self::secondary ? [
            self::term_one => 'One',
            self::term_two => 'Two',
            self::term_three => 'Three',
                ] : [
                ]
        ;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array classes
     */
    public static function classes($level) {
        return $level == self::primary || $level == self::secondary ? [
            self::form_one => [self::symbol => 'I', self::name => 'One'],
            self::form_two => [self::symbol => 'II', self::name => 'Two'],
            self::form_three => [self::symbol => 'III', self::name => 'Three'],
            self::form_four => [self::symbol => 'IV', self::name => 'Four']
                ] : [
                ]
        ;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array classes
     */
    public function classesForDropdown($level) {
        foreach (static::classes($level) as $id => $class)
            $classes[$id] = $class[self::name];

        return $classes;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array departments
     */
    public static function departments($level) {
        return $level == self::primary || $level == self::secondary ? [
            self::lang => 'Language Subjects',
            self::scnc => 'Science Subjects',
            self::hmnt => 'Humanity Subjects',
            self::tcnl => 'Technical Subjects'
                ] : [
                ]
        ;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array subjects
     */
    public static function subjects($level) {
        return $level == self::primary || $level == self::secondary ? [
            /* languages in alphabetical order */
            'eng' => [self::code => 101, self::dept => self::lang, self::name => 'English'],
            'kis' => [self::code => 102, self::dept => self::lang, self::name => 'Kiswahil'],
            /* sciences in alphabetical order */
            'bio' => [self::code => 104, self::dept => self::scnc, self::name => 'Biology'],
            'bsc' => [self::code => 105, self::dept => self::scnc, self::name => 'Biological Sciences'],
            'che' => [self::code => 106, self::dept => self::scnc, self::name => 'Chemistry'],
            'mat' => [self::code => 103, self::dept => self::scnc, self::name => 'Mathematics'],
            'phy' => [self::code => 107, self::dept => self::scnc, self::name => 'Physics'],
            /* humanities in alphabetical order */
            'cre' => [self::code => 110, self::dept => self::hmnt, self::name => 'Christian Religious Education'],
            'geo' => [self::code => 108, self::dept => self::hmnt, self::name => 'Geography'],
            'hre' => [self::code => 112, self::dept => self::hmnt, self::name => 'Hindu Religious Education'],
            'his' => [self::code => 109, self::dept => self::hmnt, self::name => 'History and Government'],
            'ire' => [self::code => 111, self::dept => self::hmnt, self::name => 'Islamic Religious Education'],
            /* technicals in alphabetical order */
            'agr' => [self::code => 113, self::dept => self::tcnl, self::name => 'Agriculture'],
            'ara' => [self::code => 121, self::dept => self::tcnl, self::name => 'Arabic'],
            'art' => [self::code => 117, self::dept => self::tcnl, self::name => 'Art and Design'],
            'avi' => [self::code => 118, self::dept => self::tcnl, self::name => 'Aviation'],
            'bus' => [self::code => 114, self::dept => self::tcnl, self::name => 'Business Studies'],
            'cpt' => [self::code => 115, self::dept => self::tcnl, self::name => 'Computer Studies'],
            'fre' => [self::code => 119, self::dept => self::tcnl, self::name => 'French'],
            'ger' => [self::code => 120, self::dept => self::tcnl, self::name => 'German'],
            'hsc' => [self::code => 116, self::dept => self::tcnl, self::name => 'Home Science'],
            'msc' => [self::code => 122, self::dept => self::tcnl, self::name => 'Music']
                ] : [
                ]
        ;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @param array $toRemoves subjects to be removed
     * @return array subjects for dropdown
     */
    public static function subjectsForDropDown($level, $toRemoves) {
        if ($level == self::primary || $level == self::secondary)
            foreach ($subjects = static::subjects() as $key => $subject) {

                $removed = false;

                foreach ($toRemoves as $toRemove)
                    if ($toRemove === $key) {
                        unset($subjects[$key]);
                        $removed = true;
                    }

                if (!$removed)
                    $subjects[$key] = $subject[self::name];
            } else
            $subjects = [];

        return $subjects;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array grades
     */
    public static function grades($level) {
        return $level == self::primary || $level == self::secondary ? [
            'A' => [self::name => 'A Plain', self::points => 12],
            'A-' => [self::name => 'A Minus', self::points => 11],
            'B+' => [self::name => 'B Plus', self::points => 10],
            'B' => [self::name => 'B Plain', self::points => 9],
            'B-' => [self::name => 'B Minus', self::points => 8],
            'C+' => [self::name => 'C Plus', self::points => 7],
            'C' => [self::name => 'C Plain', self::points => 6],
            'C-' => [self::name => 'C Minus', self::points => 5],
            'D+' => [self::name => 'D Plus', self::points => 4],
            'D' => [self::name => 'D Plain', self::points => 3],
            'D-' => [self::name => 'D Minus', self::points => 2],
            'E' => [self::name => 'E Plain', self::points => 1],
            self::missed => [self::name => 'Missed Exam', self::points => 0],
            self::irregularity => [self::name => 'Irregularity', self::points => 0]
                ] : [
                ]
        ;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array grades for drop down
     */
    public static function gradesForDropDown($level) {
        if ($level == self::primary || $level == self::secondary)
            foreach ($grades = self::grades($level) as $grd => $grade)
                if (in_array($grd, [self::missed, self::irregularity]))
                    unset($grades[$grd]);
                else
                    $grades[$grd] = $grade[self::name];
        else
            $grades = [];

        return $grades;
    }

    /**
     * 
     * @param string $level primary or secondary
     * @param real $points points
     * @return string grade
     */
    public static function gradeForPoints($level, $points) {
        if ($level == self::primary || $level == self::secondary)
            foreach (self::grades($level) as $grd => $grade)
                if ($points > 0 && $points <= 12 && $points >= $grade[self::points] - 0.5 && $points < $grade[self::points] + 0.5)
                    return $grd;

        return '0';
    }

    /**
     * 
     * @param string $level primary or secondary
     * @return array cats / exams
     */
    public static function exams($level) {
        return $level == self::primary || $level == self::secondary ? [
            self::cat1 => [self::symbol => 'I', self::name => 'One'],
            self::cat2 => [self::symbol => 'II', self::name => 'Two'],
            self::cat3 => [self::symbol => 'III', self::name => 'Three'],
            self::cat4 => [self::symbol => 'AVG', self::name => 'Average']
                ] : [
                ]
        ;
    }

}
