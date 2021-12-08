<?php
    class PostsContr extends post
    {
        private $subject;
        private $content;
        private $category;

        public function __construct($subject, $content, $category)
        {
            $this->subject = $subject;
            $this->content = $content;
            $this->category = $category;
        }

       public function PostContent() {
            if($this->emptyInput() == false)
            {
                header("location: create.php?error=emptyinput");
                exit();
            }
            $this->PostToDB($this->subject, $this->content, $this->category);
       }

       private function emptyInput() {
        $result = 0;
        if(empty($this->subject) || empty($this->content) || empty($this->category)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
    }


?>