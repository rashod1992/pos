<?php

require('MainController.php');

//include_once('../Helpers/PHPMailer_5.2.4/class.phpmailer.php');

class HomeController extends MainController{

    
    public function loadMetaValue($meta_key){
        $api = new Home;

        $info = $api->loadMetaValue($meta_key);
        if(count($info)>0){
            $info = $info['meta_value'];
        }else{
            $info = "";
        }
        return $info;
        
    }
    

    public  function loaduserBySid(){

        

        $api = new Home;

        $info = $api->loaduserBySid();

        return $info;

        

    }

    public function create_slug($string){

        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);

        return $slug.time();

    }

    

    public function insertNewBrand($name,$image1,$image2,$description,$link){

        

        $api = new Home;

        $slug = $this->create_slug($name);

        $info = $api->insertNewBrand($name,$slug,$image1,$image2,$description,$link);

        return $info;

    }

    public  function loadBrandByID($id){

        

        $api = new Home;

        $info = $api->loadBrandByID($id);

        return $info;

        

    }
    public  function loadNewsByID($id){

        

        $api = new Home;

        $info = $api->loadNewsByID($id);

        return $info;

        

    }

    public function updateBrand($name,$image1,$image2,$description,$link,$id){

        

        $api = new Home;

        $slug = $this->create_slug($name);

        $info = $api->updateBrand($name,$image1,$image2,$description,$link,$id);

        return $info;

    }

    public  function loadBrandList(){

        $api = new Home;

        $info = $api->loadBrandList();

        return $info;
    }
    public  function loadProjectsList(){

        $api = new Home;

        $info = $api->loadProjectsList();

        return $info;
    }
    public  function loadNewsList(){

        $api = new Home;

        $info = $api->loadNewsList();

        return $info;
    }

     public  function loadBrandListfront(){

        

        $api = new Home;

        $info = $api->loadBrandListfront();

        return $info;

        

    }

    public  function loadCatList(){

        

        $api = new Home;

        $info = $api->loadCatList();

        return $info;

        

    }

    public function insertNewProduct($name,$brand,$theropy,$category,$country,$link){

        

        $api = new Home;

        $slug = $this->create_slug($name);

        $info = $api->insertNewProduct($name,$slug,$brand,$theropy,$category,$country,$link);

        return $info;

    }

    public function updateProduct($name,$brand,$theropy,$category,$country,$link,$id){

        

        $api = new Home;

        $info = $api->updateProduct($name,$brand,$theropy,$category,$country,$link,$id);

        return $info;

    }

    public  function loadProductByID($id){

        

        $api = new Home;

        $info = $api->loadProductByID($id);

        return $info;

        

    }

    public  function loadProductsList(){

        

        $api = new Home;

        $info = $api->loadProductsList();

        return $info;

        

    }

    public  function loadCategoryBySlug($slug){

        

        $api = new Home;

        $info = $api->loadCategoryBySlug($slug);

        return $info;

        

    }

    public function ordersCount(){
        $api = new Home;

        $info = $api->ordersCount();

        return $info['count'];
    }
    public function ordersTotalValue(){
        $api = new Home;

        $info = $api->ordersTotalValue();

        return $info['count'];
    }
    public function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
		if(isset($_SESSION['user_lang']) && $_SESSION['user_lang']==1){
					if ($n > 1000000000000) return round(($n/1000000000000), 2).' T';
				elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';
				elseif ($n > 1000000) return round(($n/1000000), 2).' M';
				elseif ($n > 1000) return round(($n/1000), 2).' K';
		}elseif(isset($_SESSION['user_lang']) && $_SESSION['user_lang']==2){
					if ($n > 1000000000000) return ' ට්‍රිලියන '.round(($n/1000000000000), 2);
				elseif ($n > 1000000000) return ' බිලියන '.round(($n/1000000000), 2);
				elseif ($n > 1000000) return ' මිලියන '.round(($n/1000000), 2);
				elseif ($n > 1000) return ' දහස් '.round(($n/1000), 2);
		}else{
					if ($n > 1000000000000) return round(($n/1000000000000), 2).' T';
				elseif ($n > 1000000000) return round(($n/1000000000), 2).' B';
				elseif ($n > 1000000) return round(($n/1000000), 2).' M';
				elseif ($n > 1000) return round(($n/1000), 2).' K';
		}
        

        return number_format($n);
    }
	public function customersCount(){
		 $api = new Home;

        $info = $api->customersCount();

        return $info['count'];
	}
	public function productsCount(){
		 $api = new Home;

        $info = $api->productsCount();

        return $info['count'];
	}

}



