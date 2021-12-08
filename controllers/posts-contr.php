<?php
    class PostsContr extends post
    {
        private $content;
        private $category;

        public function __construct($content, $category)
        {
            $this->content = $content;
            $this->category = $category;
        }

       public function PostContent() {
            if($this->emptyInput() == false)
            {
                header("location: ?error=emptyinput");
                exit();
            }
            $this->PostToDB($this->content, $this->category);
            
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