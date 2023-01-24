<?php



namespace App\Controller\admin;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ListPlaylistController
 *
 * @author hachm
 */
class ListPlaylistController extends AbstractController {
    
    
    /**
     * 
     * @var PlaylistRepository
     */
    private $playlistRepository;
    
    public function __construct(PlaylistRepository $playlistRepository) {
        $this->playlistRepository = $playlistRepository;
    }

    
    
    /**
     * @Route("/admin/playlists" , name="adminplaylists")
     * @return Response
     */ 
    public function index(): Response {
        
      $playlists = $this->playlistRepository->findAll();
        
        return $this->render("admin/lesPlaylists.html.twig", [
            'playlists' => $playlists,
            
        ]);
    }
     /**
     * @Route ("/admin/suppr/{id}", name="playlists.suppr")
     * @param Playlist $playists
     * @return Response
     */
   public function suppr(Playlist  $playlists):Response{
       $this ->playlistRepository->remove($playlists,true);
       return $this->redirectToRoute('adminplaylists');
   }
   /**
     * @Route ("/admin/playlists/sort//{ordre}" , name="playlists.sort")
     *
     * @param type $ordre
     */
    
    public function sort( $ordre):Response{
        
        $playlists=$this->playlistRepository->findAllOrderByName($ordre);
        return $this->render("admin/lesPlaylists.html.twig",[
            'playlists'=>$playlists 
        ]);
    }
    
    /**
     * @Route("/admin/edit/{id}" , name="playlists.edit")
     * @param Playlist $playlist
     * @param Request $request
     * @return Response
     */
    public function edit(Playlist $playlists, Request $request):Response {
        
        $formPlaylists = $this->createForm(PlaylistType::class, $playlists);
        $formPlaylists->handleRequest($request);
        if($formPlaylists->isSubmitted()&& $formPlaylists->isValid()){
            $this->playlistRepository->add($playlists,true);
            return $this->redirectToRoute('adminplaylists');
        }
        return $this->render("admin/playlists.edit.html.twig", [
            'playlists'=>$playlists ,
            'formplaylist'=>$formPlaylists->createView()
        ]);
        
    }
    
    /**
     * @Route("/admin/playlists/filtrer/{champ}/{table}", name="playlists.filtre")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        return $this->render("admin/lesPlaylists.html.twig", [
            'playlists' => $playlists,           
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    
    /**
     * @Route("/admin/playlists/ajout" ,name="playlists.ajout")
     * @param Request $request
     * @return Response
     */
     public function ajout(Request $request): Response{
        $playlist = new Playlist();
       
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);

        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist, true);
            return $this->redirectToRoute('adminplaylists');
        } 
       
        return $this->render("admin/playlists.ajout.html.twig", [
            'playlist' => $playlist,
            'formplaylist' => $formPlaylist->createView()
        ]);        
    }  
    
     
}
