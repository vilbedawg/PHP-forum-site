<?php
    class PostsContr extends post
    {
        private $subject;
        private $topic;
        private $category;
        

        public function __construct($subject, $topic, $category)
        {
            $this->subject = $subject;
            $this->topic = $topic;
            $this->category = $category;
        }

       public function PostTopic() {
        if($this->emptyPostInput() == false)
        {
            header("location: ?error=emptyinput");
            exit();
        }
        $this->PostTopicToDB($this->category, $this->subject, $this->topic);
        
        }

        public function updateTopic($roomNum) {
            if($this->emptyPostInput() == false)
            {
                header("location: view.php?room=$roomNum&edit&error=emptyinput");
                exit();
            }
            $this->updateTopicToDB($this->category, $this->subject, $this->topic, $roomNum);
            
            }





        private function emptyPostInput() {
            $result = 0;
            if(empty($this->subject or $this->category  or $this->topic )) {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }
}


?>