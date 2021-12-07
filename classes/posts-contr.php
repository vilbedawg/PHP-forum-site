<?php
    class PostsContr extends post
    {
        private $subject;
        private $content;


        public function __construct($subject, $content)
        {
            $this->subject = $subject;
            $this->content = $content;
        }

       public function PostContent() {
            if($this->emptyInput() == false)
            {
                header("location: users.php?error=emptyinput");
                exit();
            }
            $this->PostToDB($this->subject, $this->content);
       }

       private function emptyInput() {
        $result = 0;
        if(empty($this->subject) || empty($this->content)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
    }


?>