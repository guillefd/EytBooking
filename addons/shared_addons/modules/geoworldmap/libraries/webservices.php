<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Webservices 
{

    protected $ci;
    
    public function __construct($params)
    {  
        ci()->config->load('webservices');            
    }    
    
    /**
        * Webservice Type : REST 
        Url : api.geonames.org/timezone?
        Parameters : lat,lng, radius (buffer in km for closest timezone in coastal areas), date (date for sunrise/sunset);
        Result : the timezone at the lat/lng with gmt offset (1. January) and dst offset (1. July) 
        * @param type $lat
        * @param type $long 
        */
    public function geonames_timezone_by_lat_long($lat,$long)
    {                    
        $url = 'http://api.geonames.org/timezoneJSON?lat='.$lat.'&lng='.$long.'&username='.ci()->config->item('geonames_user');          
        $options = array('method' => 'POST','header'=>'Content-type: text/plain;charset=UTF-8');
        $context = stream_context_create(array('http' => $options));
        $result = file_get_contents($url, false, $context);
        if($result)
        {
            return $result;
        }else
            {
                return FALSE;
            }
    }
    
        /**
        * Webservice Type : REST 
        * Url : api.geonames.org/countrySubdivision?
        * Parameters : lat,lng, lang (default= names in local language), radius (buffer in km for closest country in coastal areas, a positive buffer expands the positiv area whereas a negative buffer reduces it),level (level of ADM);
        * Result : returns the country and the administrative subdivison (state, province,...) for the given latitude/longitude
        * @param type $lat
        * @param type $long 
        */
    public function geonames_countryinfo_by_lat_long($lat,$long)
    {                    
        $url = 'http://api.geonames.org/countrySubdivisionJSON?lat='.trim($lat).'&lng='.trim($long).'&username='.ci()->config->item('geonames_user');           
        $options = array('method' =>'POST','header'=>'Accept-Language: es-ES; Content-type: html/text; charset=UTF-8;');
        $context = stream_context_create(array('http' => $options));
        $result = file_get_contents($url, false, $context);
        if($result)
        {
            return $result;
        }else
            {
                return FALSE;
            }
    }   
    

    public function geonames_countryinfo_by_countrycode($code)
    {                    
        $url = 'http://api.geonames.org/countryInfo?country='.trim($code).'&username='.ci()->config->item('geonames_user');           
        $options = array('method' =>'POST','header'=>'Accept-Language: es-ES; Content-type: text/text; charset=UTF-8;');
        $context = stream_context_create(array('http' => $options));
        $result = file_get_contents($url, false, $context);
        if($result)
        {
            return $result;
        }else
            {
                return FALSE;
            }
    }       
    
    
    
    /**
     * API de codificación geográfica de Google
     * Transforma direcciones en coordenadas geográficas
     * address, bounds, region, language, sensor
     * http://maps.googleapis.com/maps/api/geocode/json?address=address,+city,+region,+country&sensor=true_or_false
     */
    public function googleapis_geocode($params)
    {
       $search_string = '';
       $search_string.= array_key_exists('address', $params) ? '+'.str_replace(' ','+',trim($params['address'])).',' : '' ;
       $search_string.= array_key_exists('city', $params) ? '+'.str_replace(' ','+',trim($params['city'])).',' : '' ;
       $search_string.= array_key_exists('region', $params) ? '+'.str_replace(' ','+',trim($params['region'])).',' : '' ;       
       $search_string.= array_key_exists('country', $params) ? '+'.str_replace(' ','+',trim($params['country'])) : '' ;
       $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.$search_string.'&sensor=false'; 
       $options = array('method' =>'GET','header'=>'Accept-Language: es-ES; Content-type: text/html; charset=ISO-8859-1;');
       $context = stream_context_create(array('http' => $options));
       $result = file_get_contents($url, false, $context);   
       if($result)
        {
            return $result;
                        
        }else
            {
                return FALSE;
            }       
    }
    
    
}

/* End of file Someclass.php */  

        
