<?php
namespace App\Controller\admin;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Description of ListeFormationsController
 *
 * @author hachm
 */
class ListeFormationsController extends AbstractController{
    
   
    /**
     * 
     * @var FormationRepository
     */
    private $formationRepository;
    
   
    
    public function __construct( FormationRepository $formationRepository) {
        
        $this->formationRepository = $formationRepository;
    }
        

    
    /**
     * @Route("/admin/formations" , name="adminformations")
     * @return Response
     */ 
    public function index(): Response {
        
      $formations = $this->formationRepository->findAll();
        
        return $this->render("admin/lesFormations.html.twig", [
            'formations' => $formations,
            
        ]);
    }
    
    /**
     * @Route("/formation/filtrer/{champ}/{table}", name="formations.filtre")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $formation = $this->formationRepository->findByContainValue($champ, $valeur, $table);
       
        return $this->render("admin/lesFormations.html.twig", [
            'formations' => $formation,           
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
    /**
     * @Route ("/admin/suppr/{id}", name="formations.suppr")
     * @param Formation $Formation
     * @return Response
     */
   public function suppr(Formation $formation):Response{
       $this ->formationRepository->remove ($formation,true);
       return $this->redirectToRoute('adminformations');
   }
    
    /**
     * @Route ("/admin/sort/{champ}/{ordre}" , name="formations.sort")
     * @param type $champ
     * @param type $ordre
     */
    
    public function sort($champ, $ordre):Response{
        
        $formations=$this->formationRepository->TestfindAllOrderBy($champ, $ordre);
        return $this->render("admin/lesFormations.html.twig",[
            'formations'=>$formations
        ]);
    }
    
    /**
     * @Route("/admin/formation/edit/{id}" , name="formations.edit")
     * @param Formation $formation
     * @param Request $request
     * @return Response
     */
    public function edit(Formation $formation, Request $request):Response {
        
        $formFormation = $this->createForm(FormationType::class, $formation);
        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted()&& $formFormation->isValid()){
            $this->formationRepository->add($formation,true);
            return $this->redirectToRoute('adminformations');
        }
        return $this->render("admin/formation.edit.html.twig", [
            'formation'=>$formation ,
            'formformation'=>$formFormation->createView()
        ]);
        
    }
    
    /**
     * @Route("/admin/formation/ajout" , name="formations.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        $formation = new Formation();
       
        $formFormation = $this->createForm(FormationType::class, $formation);

        $formFormation->handleRequest($request);
        if($formFormation->isSubmitted() && $formFormation->isValid()){
            $this->formationRepository->add($formation, true);
            return $this->redirectToRoute('adminformations');
        } 
        //f ($formFormation->get('enregistrer')->isclicked()){
          //  $this->formationRepository->add($formation, true);
        //return $this->redirectToRoute('listeformations');

        //}
        return $this->render("admin/formation.ajout.html.twig", [
            'formation' => $formation,
            'formformation' => $formFormation->createView()
        ]);        
    }  
    
   
    
}
