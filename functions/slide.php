<?php
    class Slide {

        private $db;

        function __construct($conn) {
            //Use construct so we can use the current connection easily.
            $this->db = $conn;
        }

        public function deleteSlide($id) {
            try {
                $slide = $this->db->prepare("SELECT image FROM homepageslider WHERE ID = " . $id);
                $slide->execute();
                $slideimage = $slide->fetch(PDO::FETCH_ASSOC);

                $stmt = $this->db->prepare("DELETE FROM homepageslider WHERE ID = " . $id);
                $stmt->execute();
                unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/slider/' . $slideimage['image']);

                return $stmt;
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function createSlide($title, $image, $imagefile) {
            try {
                $imageFileType = pathinfo(basename($image),PATHINFO_EXTENSION);
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    echo 'Afbeelding kon niet worden toegevoegd, controleer als de geuploade afbeelding wel een jpg, png of jpeg bestand is!';
                    return false;
                } else {
                    $stmt = $this->db->prepare("INSERT INTO homepageslider(title, image) 
                                                       VALUES(:title, :image)");

                    $stmt->bindparam(":title", $title);
                    $stmt->bindparam(":image", $image);
                    $stmt->execute();
                    $this->uploadImage($image, $imagefile);
                    echo 'Slide is toegevoegd';

                    return $stmt;
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function editSlide($title, $image, $imagefile, $id) {
            try {
                if($imagefile['name'] == '') {
                    $stmt = $this->db->prepare("UPDATE homepageslider SET title = :title WHERE ID = " . $id);
                } else {
                    $stmt = $this->db->prepare("UPDATE homepageslider SET title = :title, image = :image WHERE ID = " . $id);
                    $stmt->bindparam(":image", $image);

                    $slide = $this->db->prepare("SELECT image FROM homepageslider WHERE ID = " . $id);
                    $slide->execute();
                    $slideimage = $slide->fetch(PDO::FETCH_ASSOC);

                    $imageFileType = pathinfo(basename($image),PATHINFO_EXTENSION);
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        return false;
                    } else {
                        $this->uploadImage($image, $imagefile);
                        unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/slider/' . $slideimage['image']);
                    }
                }

                $stmt->bindparam(":title", $title);
                $stmt->execute();

                return true;
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function getSlides() {
            try {
                $data = $this->db->prepare('SELECT * FROM homepageslider');
                $data->execute();

                return $data;
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function getSlide($id) {
            try {
                $data = $this->db->prepare('SELECT * FROM homepageslider WHERE ID = ' . $id);
                $data->execute();

                return $data;
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function uploadImage($image, $imagefile) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/slider/";
            $target_file = $target_dir . basename($image);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {

            } else {
                move_uploaded_file($imagefile["tmp_name"], $target_file);
            }
        }
    }