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

       public function PostComment() {
            if($this->emptyInput() == false)
            {
                header("location: ?error=emptyinput");
                exit();
            }
            $this->PostCommentToDB($this->content, $this->category);
            
       }

       public function PostTopic() {
        if($this->emptyPostInput() == false)
        {
            header("location: ?error=emptyinput");
            exit();
        }
        $this->PostTopicToDB($this->category, $this->subject, $this->content);
        
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

        private function emptyPostInput() {
            $result = 0;
            if(empty($this->subject && $this->category  && $this->content )) {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }
}


?>