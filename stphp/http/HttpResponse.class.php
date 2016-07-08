<?php

namespace stphp\http;

/**
 * Description of HttpResponse
 *
 * @author thiago
 * 
 * https://www.w3.org/Protocols/rfc1341/4_Content-Type.html
 * 
 */
abstract class HttpResponse {
  
  const JSON = "json";
  const HTML = "html";
  
  /**
  *
  * text: This type indicates that the content is plain text and no special software 
  *    is required to read the contents. For instance, Content-Type: text/html 
  *    indicates that the body content is html, and the client can use 
  *    this hint to kick rendering engine while displaying the response.
  * 
  * multipart: As the name indicates, this type consists of multiple parts of the 
  *    independent data types. For instance, Content-Type: multipart/form-data 
  *    is used for submitting forms that contain the files, non-ASCII data, and binary data.
  * 
  * message: This type encapsulates more messages. It allows messages to contain 
  *    other messages or pointers to other messages. For instance, the 
  *    Content-Type: message/partial content type allows for large messages to 
  *    be broken up into smaller messages. The full message can then be read by 
  *    the client (user agent) by putting all the broken messages together.
  * 
  * image: This type represents the image data. For instance, Content-Type: image/png 
  *   indicates that the body content is a .png image.
  * 
  * audio: This type indicates the audio data. For instance, Content-Type: audio/mpeg 
  *   indicates that the body content is MP3 or other MPEG audio.
  * 
  * video: This type indicates the video data. For instance Content-Type:, video/mp4 
  *   indicates that the body content is MP4 video.
  * 
  * application: This type represents the application data or binary data. 
  *   For instance, Content-Type: application/json; charset=utf-8 designates the content 
  *   to be in the JavaScript Object Notation (JSON) format, encoded with UTF-8 character encoding.
  */
  private $valid_types = array(
    "application" => array("xml", "json"),
    "audio" => array("mp3", "mpeg", "ogg"),
    "image" => array("png", "jpg", "gif"),
    "message" => array("partial"),
    "multipart" => array("form-data"),
    "text" => array("html"),
    "video" => array("mp4", "mkv")
  );
  
  
  /**
   * Type of response: JSON, HTML, XML
   * 
   * @var string
   */
  protected $type;
    
  /**
   * Specific cookie for the response
   * 
   * @var array
   */
  protected $cookie;

  /**
   * Add header for the response with name and value
   * 
   * @var array
   */
  protected $header;

  /**
   * HTTTP code status responses:  10X, 20X, 30X, 40X, 50X
   * 
   * @var int
   */
  protected $status;
  
  /**
   * @Exemple ("class_name" => "method_name")
   * 
   * Function will be executed after the request
   * 
   * @var array
   */
  protected $action;
  
  /**
   * URL to redirect after the request
   * 
   * @var string
   */
  protected $redirect;
  
  /**
   *
   * @var Array 
   */
  protected $content = array();
    
  /**
   * 
   * @param int $status
   * @param string $type
   */
  public function __construct() {
    $this->defineDefaultHttpStatus();
  }
          
  function getType() {
    return $this->type;
  }

  function getCookie() {
    return $this->cookie;
  }

  function getHeader() {
    return 'Content-Type: ' . $this->type;     
  }

  abstract function getStatus();

  function getAction() {
    return $this->action;
  }

  function getRedirect() {
    return $this->redirect;
  }

  function setType($subtype = self::JSON) {
    
    $found = false;
    foreach ($this->valid_types as $key => $vt){
      foreach ($vt as $sub_type){
        if ($sub_type == $subtype){
          $found = true;
          $this->type = $key . "/" .$sub_type;
          break;
        }
      }      
      if ($found) break;
    }
    if (!$found) {
      throw new HttpResponseException("Type undefined. See documentation: https://www.w3.org/Protocols/rfc1341/4_Content-Type.html", 400);
    }    
    
  }

  function setCookie($cookie) {
    $this->cookie = $cookie;
  }

  function defineDefaultHttpStatus(){
    $status = $this->getStatus();
    $this->setStatus($status);
  }
  
  function setStatus($status) {
    
    $status = (int) $status;    
    if (($status < 100) || ($status > 505)) {
      throw new HttpResponseException("Invalid status code. See documentation: http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml", 400);      
    }    
    $this->status = $status;
  }

  function setAction($action) {
    $this->action = $action;
  }

  function setRedirect($redirect) {
    $this->redirect = $redirect;
  }
  
  function getContent() {
    return $this->content;
  }

  
  //@TODO verificar se o content é um json.
   public function addContent(\stphp\ArraySerializable $content, $append_to = false){
    $class_name = get_class($content);
    
    if ($append_to) {

      $found = false;

      foreach ($this->content as $c) {
        $field = key($c);

        if ($field == $class_name) {
          $this->content[$class_name][] = $content->arraySerialize();
          $found = true;
          break;
        }
      }

      if (!$found) {
        $this->content[$class_name][] = $content->arraySerialize();
      }
    }
    else {
      $this->content[$class_name] = $content->arraySerialize();
    }
  }
  
  
  abstract function output();


  
}
