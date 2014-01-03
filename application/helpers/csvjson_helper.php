<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');// CSVJSON helper functions/** * generateUniqueId * * @return	string	Unique alpha-numeric key */if (!function_exists('generateUniqueId')) {	function generateUniqueId() {		return md5($_SERVER['REMOTE_ADDR'].uniqid());	}}/** * saveToDisk * * @param	string	id of object to save. Will be used as the filename. * @param	array	Data to save. * @return	bool or string	TRUE on success, error message string on failure. */if (!function_exists('saveToDisk')) {	function saveToDisk($id, $data) {		$result = file_put_contents(FCPATH."../data/$id", serialize($data));		if ($result === FALSE) return "Unexpected error trying to save to disk file $id.";		return TRUE;	}}/** * * restoreFromDisk * * @param	string	id of object to restore. * @return	array or string	Data restored from disk, or an error message strign on failure. */if (!function_exists('restoreFromDisk')) {	function restoreFromDisk($id) {		$data = unserialize(file_get_contents(FCPATH."../data/$id"));		if (!is_array($data)) return "Unexpected error trying to restore from disk file $id.";		return $data;	}}/** * uploadFileIsValid * * @param	string	filename being uploaded. Should be a key in $_FILES. * @param	string or NULL	Expected mime type. Optional when set to NULL. * @return	TRUE or string	TRUE if valid, or error message string upon failure. */if (!function_exists('uploadFileIsValid')) {	function uploadFileIsValid($filename, $expectedMime=NULL) {			if ($_FILES[$filename]['error'] !== UPLOAD_ERR_OK ||			!is_uploaded_file($_FILES[$filename]['tmp_name'])) {			return "Uplaod error: ".$_FILES[$filename]['error'];		}				if ($expectedMime) {			$mime = $this->getMimeType($_FILES[$filename]['tmp_name']);			if (!strpos($mime, $expectedMime) === 0)				return 'File upload '.$_FILES[$filename]['tmp_name']." invalid mime type: $mime. Expecting: $expectedMime";		}		return TRUE;	}}/** * getMimeType * * @param	string	filename being uploaded. Should be a key in $_FILES. * @return	string	Mime type. */if (!function_exists('getMimeType')) {	function getMimeType($file) {		if (ENVIRONMENT == 'development') return 'text/plain';		$file = escapeshellarg($file);		$mime = shell_exec("file -bi " . $file);		return $mime;	}}/** * ajaxReply * * @param	string	Value to return. * @param	bool	TRUE if we return a success (200), or FALSE if we return an error (400). * @return	nothing */if (!function_exists('ajaxReply')) {	function ajaxReply($result, $success=TRUE) {		header('Expires: -1');		if ($success == FALSE) header("HTTP/1.0 400 Bad Request");		header('Content-Type: text/html; charset=utf-8');		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');		header('Pragma: no-cache');				echo $result;	}}/* End of file upload_helper.php *//* Location: ./application/helpers/upload_helper.php */