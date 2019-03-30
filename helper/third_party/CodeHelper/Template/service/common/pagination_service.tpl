<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 分页服务
 *
 */
class Pagination_service extends MY_Service
{
    private $method = array(
        'count' => 'count',
        'find' => 'findAll',
    );

    /**
     * Hanlde
     * 
     * @param Object $model 
     * @param array $param search param
     * @param string $sortby
     * @param string|array $page_url
     * @return array
     */
    public function handle(CI_Model $model, $param = array(), $sortby = NULL, $page_url)
    {
        $total = $model->{$this->method['count']}($param);
        if($total == 0) {
            return array('total' => 0, 'current_page' => 0, 'data' => array(), 'pagination' => NULL,);
        }
        if($sortby === false) {
            $sortby = NULL;
        } elseif($sortby === NULL) {
            if($this->input->get('sortby') && in_array($this->input->get('sortby'), array_keys($model->attributes()))) {
                $sortby = $this->input->get('sortby').' '.($this->input->get('asc') ? 'ASC' : 'DESC');
            }
        }
        $this->load->config('pagination', true);
        $pagination = $this->config->item('pagination');
        $page = $this->getCurrentPage($this->input->get($pagination['query_string_segment']), $total, $pagination['per_page']);
        $data = $model->{$this->method['find']}($param, $pagination['per_page'], ($page - 1) * $pagination['per_page'], $sortby);
        
        $this->load->library('pagination');
        $this->pagination->initialize(array_merge($pagination, array(
            'base_url' => $this->getPaginationBaseUrl($page_url, $pagination['query_string_segment']),
            'total_rows' => $total,
        )));
        return array(
            'data' => $data,
            'total' => $total,
            'current_page' => $page,
            'pagination' => $this->pagination->create_links(),
        );
    }

    /**
     * Get Current Page 
     * 
     * @param int $page
     * @param int $total
     * @param int $per_page
     * @return number
     */
    public function getCurrentPage($page, $total, $per_page)
    {
        $page = intval($page);
        $page < 1 && $page = 1;
        $pages = ceil($total / $per_page);
        $page > $pages && $page = $pages;
        return $page;
    }

    /**
     * Get Pagination Base Url
     * 
     * @param string|array $page_url eg.array('product/pc', array('a' => 1, 'b' => 2))
     * @param string $filter filter param from GET
     * @return string
     */
    public function getPaginationBaseUrl($page_url, $filter = NULL)
    {
        $query = $this->input->get();
        if(! is_array($query)) {
            $query = array();
        }
        if(! empty($filter)) {
            if(! is_array($filter)) {
                $filter = array($filter);
            }
            foreach($query as $key => $val) {
                if(in_array($key, $filter)) {
                    unset($query[$key]);
                }
            }
        }
        if(! is_array($page_url)) {
            $page_url = array($page_url);
        }
        $router = isset($page_url[0]) ? $page_url[0] : '';
        $param = array();
        if(isset($page_url[1]) && is_array($page_url[1])) {
            $param = $page_url[1];
        }
        return create_url($router, array_merge($query, $param));
    }

    /**
     * Set Query Method
     * 
     * @param array $method
     * @return Helper_pagination_service
     */
    public function setMethod($method)
    {
        $this->method = array_merge($this->method, $method);
        return $this;
    }
}