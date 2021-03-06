<?php
        
        
namespace SeeItAll\assetXploreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//use Google\Cloud\Storage\StorageClient;


# Your Google Cloud Platform project ID
//$projectId = 'assetxplor';

# Instantiates a client
//$storage = new StorageClient([
   // 'projectId' => $projectId
//]);

/**
 * Level1
 *
 * @ORM\Table(name="Level1")
 * @ORM\Entity(repositoryClass="SeeItAll\assetXploreBundle\Repository\Level1Repository")
 * @ORM\HasLifecycleCallbacks
 */
class Level1
{

    private $uniqid ;

  /**
   * @ORM\ManyToOne(targetEntity="SeeItAll\assetXploreBundle\Entity\Level0" )
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL" )  
   */
//@ORM\JoinColumn(nullable=true) prohibits the creation of rooms without a level1
    private $level0;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="DISPLAY", type="string", length=255, nullable=true)
     */
    private $display;
    /**
     * @var int
     *
     * @ORM\Column(name="id_asset", type="integer", nullable=true)
     */
    private $id_asset;

      /**
     * @var int
     *
     * @ORM\Column(name="contract_number", type="integer", nullable=true )
     */
    private $contract_number;


    /**
     * @var string
     *
     * @ORM\Column(name="level1_name", type="string", length=255,  nullable=true)
     */
    private $level1Name;

    /**
    *  @var string
    * @ORM\Column(name="map_path", type="string", length=400, nullable=true)
    */
    private $map_path;
    

    /**
     * @var string
     *
     * @ORM\Column(name="img_path", type="string", length=255, nullable=true)
     */
    private $img_path;

        /**
     * @var string
     *
     * @ORM\Column(name="thumb_path", type="string", length=255, nullable=true)
     */
    private $thumb_path;

    /**
    *  @var string
    * @ORM\Column(name="note", type="string", length=50, nullable=true)
    */
    private $note;


        /**
    *  @var string
    * @ORM\Column(name="data_loc", type="string", length=400, nullable=true)
    */
    private $data_loc;


     /**
    *  @var string
    * @ORM\Column(name="360_url", type="string", length=400, nullable=true)
    */
    private $url;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Get asset_id
     *
     * @return int
     */
    public function getIdAsset()
    {
        return $this->id_asset;
    }

    /**
     * Set id_asset
     *
     * @param string $idAsset
     *
     * @return level1
     */
    public function setIdAsset($idAsset)
    {
        $this->id_asset =$idAsset;

        return $this;
    }

    /**
     * Set level1Name
     *
     * @param string $Level1Name
     *
     * @return Level1
     */
    public function setLevel1Name($Level1Name)
    {
        $this->level1Name =$Level1Name;

        return $this;
    }
    /**
     * Get data_loc
     *
     * @return string
     */
    public function getDataLoc()
    {
        return $this->data_loc;
    }

     /**
     * Set data_loc
     *
     * @param string $Dataloc
     *
     * @return level1
     */
    public function setDataLoc($DataLoc)
    {
        $this->data_loc =$DataLoc;
        return $this;
    }

    /**
     * Get level1Name
     *
     * @return string
     */
    public function getLevel1Name()
    {
        return $this->level1Name;
    }

    /**
     * Set level1Pdf
     *
     * @param string $blevel1Pdf
     *
     * @return level1
     */
    public function setLevel1Pdf($level1Pdf)
    {
        $this->level1Pdf = $level1Pdf;

        return $this;
    }

    /**
     * Get level1Pdf
     *
     * @return string
     */
    public function getNoteLevel1Pdf()
    {
        return $this->blevel1Pdf;
    }

    /**
     * Set blevel1Image
     *
     * @param string $blevel1Image
     *
     * @return blevel1
     */
    public function setBlevel1Image($blevel1Image)
    {
        $this->blevel1Image = $blevel1Image;

        return $this;
    }

    /**
     * Get level1Image
     *
     * @return string
     */
    public function getLevel1Image()
    {
        return $this->level1Image;
    }


      /**
     * SetNote
     *
     * @param string $Note
     *
     * @return level1
     */
    public function setNote($Note)
    {
        $this->note =$Note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }


        /**
     * SetContract_number
     *
     * @param string $Contract_number
     *
     * @return level1
     */
    public function setContractNumber($Contract_number)
    {
        $this->contract_number =$Contract_number;

        return $this->contract_number;
    }

    /**
     * Get Contract_number
     *
     * @return string
     */
    public function getContractNumber()
    {
        return $this->contract_number;
    }






 private $file;

// On ajoute cet attribut pour y stocker le nom du fichier temporairement
  private $tempFilename;


    public function getFile()
  {
    return $this->file;
  }

  // On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
  public function setFile(UploadedFile $file)
  {
    $this->file = $file;

    // On vérifie si on avait déjà un fichier pour cette entité
    if (null !== $this->level1Name) {
      // On sauvegarde l'extension du fichier pour le supprimer plus tard
      $this->tempFilename = $this->level1Name;


      // On réinitialise les valeurs des attributs url et alt
      $this->level1Image = null;
      $this->level1Name = null;
    }
  }


  public function getUniqiD(){
    return $this->uniqid;
}

public function setUniqiD()
{
    return $this->uniqid= uniqid();
}


  /**
   * @ORM\PreUpdate()
   *  @ORM\PrePersist()    
   * 
   */
  public function preUpload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }
            $this->setUniqId();
            $this->level1Name = $this->file->getClientOriginalName();
            $this->img_path = $this->getUploadDir().$this->getUniqId();
            $this->thumb_path=  $this->getThumbUploadDir().$this->getUniqId().'_thumb';
             
  }


 


  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */

 public function upload()
    {
      // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
      if (null === $this->file) {
        return;
      }
        //Create and upoad the thumbnail
        $this->generateThumbnail($this->file, 300,150, $quality = 75);

        //upload the full size image
        $this->file->move(
            $this->getUploadRootDir().$this->getUploadDir(), // Le répertoire de destination
            $this->uniqid // Le nom du fichier à créer, ici « id.extension »
           );
      
 
    }


   /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->level1Name;
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
    if (file_exists($this->tempFilename)) {
      // On supprime le fichier
     // unlink($this->tempFilename);
    }
  }

  
  public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'img/';
  }
  public function getMapsUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'maps/';
  }

  public function getThumbUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
    return 'optim/';
  }

  public function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/';
     
  }

  public function generateThumbnail($img, $width, $height, $quality = 90)
  {
      if (is_file($img)) {
          $imagick = new \Imagick(realpath($img));
          $imagick->setImageFormat('jpeg');
          $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
          $imagick->setImageCompressionQuality($quality);
          $imagick->thumbnailImage($width, $height, false, false);
          //$filename_no_ext = reset(explode('.', $img));
          if (file_put_contents( $this->getUploadRootDir().$this->getThumbUploadDir().$this->getUniqid().'_thumb', $imagick) === false) {
            throw new Exception("Could not put contents.");
        }
          return true;
      }
      else {
          throw new Exception("No valid image provided with {$img}.");
      }
  }
  




    /**
     * Set level1Image.
     *
     * @param string|null $level1Image
     *
     * @return Level1
     */
    public function setLevel1Image($level1Image = null)
    {
        $this->level1Image = $level1Image;

        return $this;
    }

    /**
     * Set level0.
     *
     * @param \SeeItAll\assetXploreBundle\Entity\Level0|null $level0
     *
     * @return Level1
     */
    public function setLevel0(\SeeItAll\assetXploreBundle\Entity\Level0 $level0 = null)
    {
        $this->level0 = $level0;

        return $this;
    }

    /**
     * Get level0.
     *
     * @return \SeeItAll\assetXploreBundle\Entity\Level0|null
     */
    public function getLevel0()
    {
        return $this->level0;
    }

    /**
     * Set imgPath.
     *
     * @param string|null $imgPath
     *
     * @return Level1
     */
    public function setImgPath($imgPath = null)
    {
        $this->img_path = $imgPath;

        return $this;
    }

    /**
     * Get imgPath.
     *
     * @return string|null
     */
    public function getImgPath()
    {
        return $this->img_path;
    }

    /**
     * Set thumbPath.
     *
     * @param string|null $thumbPath
     *
     * @return Level1
     */
    public function setThumbPath($thumbPath = null)
    {
        $this->thumb_path = $thumbPath;

        return $this;
    }

    /**
     * Get thumbPath.
     *
     * @return string|null
     */
    public function getThumbPath()
    {
        return $this->thumb_path;
    }

    /**
     * Set mapPath.
     *
     * @param string|null $mapPath
     *
     * @return Level1
     */
    public function setMapPath($mapPath = null)
    {
        $this->map_path = $mapPath;

        return $this;
    }

    /**
     * Get mapPath.
     *
     * @return string|null
     */
    public function getMapPath()
    {
        return $this->map_path;
    }

    /**
     * Set url.
     *
     * @param string|null $url
     *
     * @return Level1
     */
    public function setUrl($url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set display.
     *
     * @param string|null $display
     *
     * @return Level1
     */
    public function setDisplay($display = null)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display.
     *
     * @return string|null
     */
    public function getDisplay()
    {
        return $this->display;
    }
}
