<?php



namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of ListeCategoriesController
 *
 * @author hachm
 */
class ListeCategoriesController extends AbstractController{
    
    /**
     * 
     * @var CategorieRepository
     */
    private $categorirepository;
    
    public function __construct(CategorieRepository $categorirepository) {
        $this->categorirepository = $categorirepository;
         
    }

    
   

    
    /**
     * @Route("/admin/categories" , name="admincategories")
     * @return Response
     */ 
    public function index(): Response {
        
      $categories = $this->categorirepository->findAll();
      
        return $this->render("admin/LesCategories.html.twig", [
            'categories' => $categories
            
     
        ]);
        
    }
   
    
    /**
     * @Route ("/admin/categorie/suppr/{id}", name="categorie.suppr")
     * @param Categorie $categorie
     * @return Response
     */
    public function suppr(Categorie $categorie):Response{
       $this ->categorirepository->remove ($categorie,true);
       return $this->redirectToRoute('admincategories');
   }
 

    
    /**
     * @Route("/admin/categorie/ajout" , name="categorie.ajout")
     * @param Request $request
     * @return Response
     */
    public function ajout(Request $request): Response{
        
        $categorie = $request->get('nom');
        $cate= new Categorie();
        $cate->setName($categorie);
        $lescategories=$this->categorirepository->findAll();
        if (in_array($categorie , $lescategories)) {
            echo "existe deja !";
            return $this->redirectToRoute('admincategories');
            
        }ELSE {
            $this->categorirepository->add($cate, true);
            return $this->redirectToRoute('admincategories');
        }
                 //   return $this->redirectToRoute('admincategories');

        //foreach ( $lescategories as $seule){
           // $lesnoms = $seule->getName();
        
            //if ($categerie != $lesnoms){
                //    $this->categorirepository->add($cate, true);                
                 //   return $this->redirectToRoute('admincategories');

                //}else {
                   
                //   return $this->redirectToRoute('adminplaylists');
                    
               // }
       // }
            
         
       // }

         
    }
               
}

    
   

