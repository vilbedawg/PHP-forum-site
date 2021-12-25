<?php

class commentContr extends post
{
    private $content;
    private $roomNum;

    public function __construct($content, $roomNum)
    {
        $this->content = $content;
        $this->roomNum = $roomNum;
    }

    
    public function PostComment() {
        $roomNum = $_GET['room'];
        if($this->emptyInput() == false)
        {
            header("location: view.php?room=$roomNum&error=empty");
            exit();
        }
        $this->PostCommentToDB($this->content, $this->roomNum);
        
   }

    
    private function emptyInput() {
        $result = 0;
        if(empty($this->content)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}
   

?>