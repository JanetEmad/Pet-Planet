<?php 

namespace App\Services;

class Media{
    private array $file;
    private array $errors =[];
    private string $fileExtension = '';
    private string $newFileName;
    private string $fileType ='';

    public function getErrors(): array 
    { //all errors can occur
		return $this->errors;
	}

    public function getError(string $key) :?string // specific error 
    {
       if(isset($this->errors[$this->fileType][$key])){
          return self::template($this->file[$this->fileType][$key]);
       }
       return null;
    }
    public function template($value) :string{
        return "<p class='text-danger font-weight-bold'>{$value}</p>";
    }
    public function setFile(array $file): self {

		$this->file = $file;
        $typeArray = explode('/', $this->file['type']);
        $this->fileType = $typeArray[0];
        $this->fileExtension = $typeArray[1];
		return $this;
	}
    public function getNewFileName(): string {
		return $this->newFileName;
	}

        //validation on size & extension
    public function size(int $maxSize):self
    {
      if($this->file['size'] >$maxSize){
         $this->errors[$this->fileType][__FUNCTION__] = "Max Size Must Be Less Than {$maxSize} Bytes"; 
      }
      return $this;
    }
    public function extension(array $availableExtensions):self
    {
      if(! in_array($this->fileExtension,$availableExtensions)){
         $this->errors[$this->fileType][__FUNCTION__] = "Availabe Extensions Are" . implode(',',$availableExtensions); 
      }
      return $this;
    }

	/**
	 * @param array $file 
	 * @return self
	 */
    public function upload(string $pathTo) : bool//ex: assets /img/users/
    {
       $this->newFileName = uniqid().'.'.$this->fileExtension;
       $newFilePath = $pathTo .$this->newFileName;  
       return move_uploaded_file($this->file['tmp_name'],$newFilePath);
    }

    //to delete image
    public static function delete(string $path): bool
    {
        if(file_exists($path)){
            unlink($path);
            return true;
        }
        return false;

    }

}
?>