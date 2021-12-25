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
        $titleNoHTML = strip_tags($this->subject);
        $topicNoHTML = strip_tags($this->topic);

        if($this->emptyPostInput() == false)
        {
            header("location: ?error=emptyinput&title=$titleNoHTML&topic=$topicNoHTML");
            exit();
        }

        if($this->invalidTitle() == false) 
        {
            header("location: ?error=invalidTitle&title=$titleNoHTML&topic=$topicNoHTML");
            exit();
        }

        if($this->invalidLength() == false) 
            {
                header("location: ?error=invalidLength&title=$titleNoHTML&topic=$topicNoHTML");
                exit();
            }
        if($this->invalidCategory() == false) 
        {
            header("location: ?error=invalidCategory&title=$titleNoHTML&topic=$topicNoHTML");
            exit();
        }
        
        $this->cleanWhitespace();
        $this->PostTopicToDB($this->category, $this->subject, $this->topic);
        
        }




        public function updateTopic($roomNum) {
            $titleNoHTML = strip_tags($this->subject);
            $topicNoHTML = strip_tags($this->topic);
            if($this->emptyPostInput() == false)
            {
                header("location: view.php?room=$roomNum&edit&error=emptyinput&title=$titleNoHTML&topic=$topicNoHTML");
                exit();
            }
            if($this->invalidTitle() == false) 
            {
                header("location: view.php?room=$roomNum&edit&error=invalidTitle&title=$titleNoHTML&topic=$topicNoHTML");
                exit();
            }

            if($this->invalidLength() == false) 
            {
                header("location: view.php?room=$roomNum&edit&error=invalidLength&title=$titleNoHTML&topic=$topicNoHTML");
                exit();
            }
            
            
            if($this->invalidCategory() == false) 
            {
                header("location: view.php?room=$roomNum&edit&error=invalidCategory&title=$titleNoHTML&topic=$topicNoHTML");
                exit();
            }
            
            $this->cleanWhitespace();
            $this->updateTopicToDB($this->category, $this->subject, $this->topic, $roomNum);
        }






        private function invalidCategory() {
            $result = 0;
            $list = array('Yleinen', 'Politiikka', 'Valokuvaus', 'Videot', 'Tarinat', 'Taide', 'Pelit', 'Elokuvat', 'Musiikki', 'Urheilu', 'Harrastukset', 'NSFW');
            $category = ucwords(strtolower($this->category));
            if(!in_array($category, $list)) {
               $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

           

        private function emptyPostInput() {
            $result = 0;
            if(empty($this->subject && $this->topic && $this->category)) {
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }


        private function invalidTitle() {
            $result = 0;
            if(!preg_match('/^[\p{L}\p{N}]+(\s+[\p{L}\p{N}]+)*$/u', $this->subject)){
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }

        private function invalidLength() {
            $result = 0;
            if(strlen($this->subject) <= 2 || (strlen($this->subject)) >= 51) {            
                $result = false;
            } else {
                $result = true;
            }
            return $result;
        }


        private function cleanWhitespace() {
            $result = preg_replace('/\s+/', ' ', $this->subject && $this->topic);
            return $result;
        }


}


?>