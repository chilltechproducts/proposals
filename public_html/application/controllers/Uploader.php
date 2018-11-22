<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Controller {
 // This will retrieve the "intended" request method.  Normally, this is the
        // actual method of the request.  Sometimes, though, the intended request method
        // must be hidden in the parameters of the request.  For example, when attempting to
        // delete a file using a POST request. In that case, "DELETE" will be sent along with
        // the request in a "_method" parameter.
        function get_request_method() {
            global $HTTP_RAW_POST_DATA;

            if(isset($HTTP_RAW_POST_DATA)) {
                parse_str($HTTP_RAW_POST_DATA, $_POST);
            }

            if (isset($_POST["_method"]) && $_POST["_method"] != null) {
                return $_POST["_method"];
            }

            return $_SERVER["REQUEST_METHOD"];
        }
    function upload_product(){
        
            // Include the upload handler class
            require_once "handler.php";


            $uploader = new UploadHandler();

            // Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $uploader->allowedExtensions = array(); // all files types allowed by default

            // Specify max file size in bytes.
            $uploader->sizeLimit = null;

            // Specify the input name set in the javascript.
            $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

            // If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
            $uploader->chunksFolder = "chunks";

            $method = $this->get_request_method();



            if ($method == "POST") {
                header("Content-Type: text/plain");

                // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
                // For example: /myserver/handlers/endpoint.php?done
                if (isset($_GET["done"])) {
                    $result = $uploader->combineChunks("/home/chilltech/public_html/public/uploads");
                }
                // Handles upload requests
                else {
                    // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                    $result = $uploader->handleUpload("/home/chilltech/public_html/public/uploads");

                    // To return a name used for uploaded file you can use the following line.
                    $result["uploadName"] = $uploader->getUploadName();
                }
                
                if($result['success']){
                $pathinfo = pathinfo($uploader->getName());
                $ext = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';
        
                $this->load->database();
                    $this->db->query("insert into " . $this->input->post('table') . " (id, path, model_number, filetype) values(null, '/public/uploads/" . $result['uuid'] . "/" . $result['uploadName'] . "', '" . $this->input->post('model_number') . "', '" . $ext . "')");
                
                }
                echo json_encode($result);
            }
            // for delete file requests
            else if ($method == "DELETE") {
            $this->load->database();
                $result = $uploader->handleDelete("/home/chilltech/public_html/public/uploads");
                $this->db->query("update " . $this->input->post('table') . " set " . $this->input->post('which') . "='' where user_id=" . $this->input->post('user_id'));
                echo json_encode($result);
            }
            else {
                header("HTTP/1.0 405 Method Not Allowed");
            }
        }
    function upload(){
        
            // Include the upload handler class
            require_once "handler.php";


            $uploader = new UploadHandler();

            // Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
            $uploader->allowedExtensions = array(); // all files types allowed by default

            // Specify max file size in bytes.
            $uploader->sizeLimit = null;

            // Specify the input name set in the javascript.
            $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

            // If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
            $uploader->chunksFolder = "chunks";

            $method = $this->get_request_method();



            if ($method == "POST") {
                header("Content-Type: text/plain");

                // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
                // For example: /myserver/handlers/endpoint.php?done
                if (isset($_GET["done"])) {
                    $result = $uploader->combineChunks("/home/chilltech/public_html/public/uploads");
                }
                // Handles upload requests
                else {
                    // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                    $result = $uploader->handleUpload("/home/chilltech/public_html/public/uploads");

                    // To return a name used for uploaded file you can use the following line.
                    $result["uploadName"] = $uploader->getUploadName();
                }
                
                if($result['success']){
              
                $this->load->database();
                    $this->db->query("update " . $this->input->post('table') . " set " . $this->input->post('which') . "='/public/uploads/" . $result['uuid'] . "/" . $result['uploadName'] . "' where user_id=" . $this->input->post('user_id'));
                
                }
                echo json_encode($result);
            }
            // for delete file requests
            else if ($method == "DELETE") {
            $this->load->database();
                $result = $uploader->handleDelete("/home/chilltech/public_html/public/uploads");
                $this->db->query("update " . $this->input->post('table') . " set " . $this->input->post('which') . "='' where user_id=" . $this->input->post('user_id'));
                echo json_encode($result);
            }
            else {
                header("HTTP/1.0 405 Method Not Allowed");
            }
        }
}
