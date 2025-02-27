<?php
class PreviewProvider{

    private $con,$username;

    public function __construct($con,$username){
        $this->con=$con;
        $this->username=$username;
    }

    public function createPreviewVideo($entity){
        if($entity==null){
            $entity = $this->getRandomEntity();
        }

        $id = $entity->getId();
        $name= $entity->getName();
        $preview= $entity->getPreview();
        $thumbnail= $entity->getThumbnail();

        /* echo "<img src='$thumbnail'>"; */

        return"<div class='previewContainer'>
                <img src='$thumbnail' class='previewImage' hidden>

                <video autoplay muted class='previewVideo' onended='previewEnded()'>
                <source src='$preview' type='video/mp4'>
                </video>
                <div class='previewOverlay'>
                
                    <div class='mainDetails'>
                    <h3>$name</h3>

                     <div class='buttons'>
                        <button><i class='fa-solid fa-play'></i> Play</button>
                        <button onclick='volumeToggle(this)'><i class='fa-solid fa-volume-xmark'></i></button>

                    </div>
                    
                    </div>

                   



                </div>

                </div>";
    }

    public function createEntityPreviewSquare($entity){
        $id = $entity->getId();
        $thumbnail = $entity->getThumbnail();
        $name = $entity->getName();

        return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>";
    }




    private function getRandomEntity() {
       $query= $this->con->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
       $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);


        return new Entity($this->con,$row);



    }

}
?>