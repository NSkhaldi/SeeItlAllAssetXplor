<?php

namespace SeeItAll\assetXploreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Map
 *
 * @ORM\Table(name="Map")
 * @ORM\Entity(repositoryClass="SeeItAll\assetXploreBundle\Objects\MapRepository")
 * @ORM\HasLifecycleCallbacks 
 */
class Map
{

     /**
   * @ORM\OneToOne(targetEntity="SeeItAll\assetXploreBundle\Entity\Level0")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")  
   */
//@ORM\JoinColumn(nullable=false) prohibits the creation of pdfs without a building
private $level0;

 /**
   * @ORM\OneToOne(targetEntity="SeeItAll\assetXploreBundle\Entity\Level1", cascade={"remove"})
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")  
   */
//@ORM\JoinColumn(nullable=false) prohibits the creation of pdfs without a building
private $level1;

 /**
   * @ORM\OneToOne(targetEntity="SeeItAll\assetXploreBundle\Entity\Level2")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")  
   */
//@ORM\JoinColumn(nullable=false) prohibits the creation of pdfss without a room 
private $level2;

 /**
   * @ORM\OneToOne(targetEntity="SeeItAll\assetXploreBundle\Entity\Level3")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")  
   */
//@ORM\JoinColumn(nullable=false) prohibits the creation of pdfss without a room 
private $level3;

 /**
   * @ORM\OneToOne(targetEntity="SeeItAll\assetXploreBundle\Entity\Level4")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")  
   */
//@ORM\JoinColumn(nullable=false) prohibits the creation of pdfss without a room 
private $level4;
 




    /**
     * @var string
     *
     * @ORM\Column(name="map_name", type="string", length=255, nullable=true)
     */
    private $MapName;

        /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $Path;


        /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    private $uniqid;

    private $tempFilename;

    private $file;


    public function getFile()
  {
    return $this->file;
  }

  // On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
  public function setFile(UploadedFile $file)
  {
    $this->file = $file;

    
    // On vérifie si on avait déjà un fichier pour cette entité
    if (null !== $this->Path) {
      // On sauvegarde l'extension du fichier pour le supprimer plus tard
      $this->tempFilename = $this->Path;

      // On réinitialise les valeurs des attributs url et alt
      $this->Path = null;
      
      $this->PdfName = null;
    }
  }

 

  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }
    $this->uniqid= uniqid();
    // Le nom du fichier est son id, on doit juste stocker également son extension
    // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »
    $this->Path = $this->getUploadDir().'/'.$this->uniqid;

    // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
    $this->MapName = $this->file->getClientOriginalName();
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
        
         // Si on avait un ancien fichier, on le supprime
    if (null !== $this->tempFilename) {
      $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
      if (file_exists($oldFile)) {
        unlink($oldFile);
      }
    }

        // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move(
      $this->getUploadRootDir(), // Le répertoire de destination
      $this->uniqid  // Le nom du fichier à créer, ici « id.extension »
    );
    }


   /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    // On sauvegarde temporairement le nom du fichier, car il dépend de l'id
    //$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->roomImage;
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    // En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
    if (file_exists($this->tempFilename)) {
      // On supprime le fichier
      unlink($this->tempFilename);
    }
  }

  
    public function getUploadDir()
    {
      // On retourne le chemin relatif vers l'image pour un navigateur (relatif au répertoire /web donc)
      return 'uploads/maps';
    }
  
    public function getUploadRootDir()
    {
      // On retourne le chemin relatif vers l'image pour notre code PHP
      return __DIR__.'/../../../../web/'.$this->getUploadDir();
       
    }



 public function getUniqId(){

    return $this->uniqid;
 }


    /**
     * Set mapName.
     *
     * @param string|null $mapName
     *
     * @return Map
     */
    public function setMapName($mapName = null)
    {
        $this->MapName = $mapName;

        return $this;
    }

    /**
     * Get mapName.
     *
     * @return string|null
     */
    public function getMapName()
    {
        return $this->MapName;
    }

    /**
     * Set path.
     *
     * @param string|null $path
     *
     * @return Map
     */
    public function setPath($path = null)
    {
        $this->Path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->Path;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level0.
     *
     * @param \SeeItAll\assetXploreBundle\Entity\Level0|null $level0
     *
     * @return Map
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
     * Set level1.
     *
     * @param \SeeItAll\assetXploreBundle\Entity\Level1|null $level1
     *
     * @return Map
     */
    public function setLevel1(\SeeItAll\assetXploreBundle\Entity\Level1 $level1 = null)
    {
        $this->level1 = $level1;

        return $this;
    }

    /**
     * Get level1.
     *
     * @return \SeeItAll\assetXploreBundle\Entity\Level1|null
     */
    public function getLevel1()
    {
        return $this->level1;
    }

    /**
     * Set level2.
     *
     * @param \SeeItAll\assetXploreBundle\Entity\Level2|null $level2
     *
     * @return Map
     */
    public function setLevel2(\SeeItAll\assetXploreBundle\Entity\Level2 $level2 = null)
    {
        $this->level2 = $level2;

        return $this;
    }

    /**
     * Get level2.
     *
     * @return \SeeItAll\assetXploreBundle\Entity\Level2|null
     */
    public function getLevel2()
    {
        return $this->level2;
    }

    /**
     * Set level3.
     *
     * @param \SeeItAll\assetXploreBundle\Entity\Level3|null $level3
     *
     * @return Map
     */
    public function setLevel3(\SeeItAll\assetXploreBundle\Entity\Level3 $level3 = null)
    {
        $this->level3 = $level3;

        return $this;
    }

    /**
     * Get level3.
     *
     * @return \SeeItAll\assetXploreBundle\Entity\Level3|null
     */
    public function getLevel3()
    {
        return $this->level3;
    }

    /**
     * Set level4.
     *
     * @param \SeeItAll\assetXploreBundle\Entity\Level4|null $level4
     *
     * @return Map
     */
    public function setLevel4(\SeeItAll\assetXploreBundle\Entity\Level4 $level4 = null)
    {
        $this->level4 = $level4;

        return $this;
    }

    /**
     * Get level4.
     *
     * @return \SeeItAll\assetXploreBundle\Entity\Level4|null
     */
    public function getLevel4()
    {
        return $this->level4;
    }
}
