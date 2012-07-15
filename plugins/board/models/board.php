<?php
class Board extends BoardAppModel {

	var $name = "Board";
	
	var $useTable = "board_articles";
  var $cacheSources = true;
	var $primaryKey = "no";

	var $validate = array(
									'bid' => array('rule' => 'notEmpty','required' => true),
									'subject' => array(
                                                'notempty'=>array('rule'=>'notEmpty','required' => true,'minLength'=>'2','message'=>'* 제목을 입력하십시오'),
                                                'filter'=>array('rule'=>array('filtering','word'),'message'=>'* 허용되지 않는 단어가 포함되어 있습니다.')
                                     ),
									'name' => array('rule' => 'notEmpty','required' => true),
									'email'=>array('rule'=>'email','allowEmpty'=>true),
									'homepage'=>array('rule' => 'url','allowEmpty'=>true),
									'passwd' => array('rule' => 'notEmpty','required' => true),
									'content' => array(
                                                'notempty'=>array('rule'=>'notEmpty','required' => true,'minLength'=>'5','message'=>'* 내용을 입력하십시오'),
                                                'filter'=>array('rule'=>array('filtering','word'),'message'=>'* 허용되지 않는 단어가 포함되어 있습니다.')
                                                 )
									);

	var $hasOne = array();

	var $belongsTo = array(
				'BoardCategory' =>
                        array('className'    => 'BoardCategory',
								'conditions'   => '',
								'fields'=>'name',
								'order'        => '',
								'dependent'    =>  false,
								'foreignKey'   => 'category',
                        ),
				'User'=>array(
		    			'className'=>'User',
		    			'foreignKey'=>'userid'
		    		)
		                            
	);

	var $hasMany = array(
				'Fileattach' =>array('className'    => 'Fileattach',
													'conditions'   => array('Fileattach.deleted'=>null,'plugin'=>'board'),
													'fields'=>array('id','name','fsname'),
													'order'        => array('expose'=>'desc'),
													'dependent'    =>  true,
													'foreignKey'   => 'parent_id',
                        ),
/*
				'Rating' =>array('className'   => 'Rating',
                           'foreignKey'  => 'model_id',
                           'conditions' => array('Rating.model' => 'Board.Board'),
                           'dependent'   => true,
                           'exclusive'   => true                         
                           )
*/
	);


    
   var $filter = null;



    function filtering($data,$w){
        if( is_array($data) ){
            $data = array_pop($data);
        }

        //if( empty($data) ) return false;
        if( $w == 'ip' ){

        }elseif( $w == 'word' ){
            $words = implode("|",explode("\r\n",trim($this->filter)));
						if( empty($words) ) return true;
            if( eregi($words,$data) ) return false;
            else return true;
        }
        return false;
    }

	//댓글 수 업데이트
	function setTotalComments($bid,$no,$cnt){
		if( $this->query("update ".$this->tablePrefix.$this->table." set total_comment=".$cnt." where bid='".$bid."' AND no=".$no) ){
			return false;
		}else{
			return true;
		}
	}


	
	function updateDel(){

		//답변글도 모두 삭제되도록 설정
		if( $this->id ){
			
			$data = $this->read(array('bid','sort_no','sort_gno','sort_depth'),$this->id);
			
			$bid = $data[$this->name]['bid'];
			$sortno = $data[$this->name]['sort_no'];
			$sortgno = $data[$this->name]['sort_gno'];
			$sortdepth = $data[$this->name]['sort_depth'];			
			
			$this->query("update ".$this->tablePrefix.$this->table." set deleted=sysdate() where no=".$this->id);	 //선택글 삭제	

			$this->query("update ".$this->tablePrefix.$this->table." set deleted=sysdate() where bid='$bid' and sort_gno='$sortgno' and sort_no > '$sortno' and sort_depth > '$sortdepth'" ); //선택글의 답변글 삭제
			
			return true;
		}else{
			return false;
		}

	}


//	function latest($bid,$category=null,$limit=5,$cut=45,$cut2=100){
	function latest($data){
		$bid 			= @$data['bid'];
		$category = @$data['category'];
		$limit 		= @$data['limit']?$data['limit']:5;
		$slen 		= @$data['slen']?$data['slen']:45;
		$clen 		= @$data['clen']?$data['clen']:100;		
		$bname 		= @$data['bname']?TRUE:FALSE;		
	
		$conditions = array('Board.deleted'=>null);
		if( $category !== null ){
			$conditions = array_merge($conditions,array('Board.category'=>$category));		
		}
		if( is_array($bid) == true ){
			$conditions = array_merge($conditions,array("Board.bid in ('".implode("','",$bid)."')"));
		}elseif( $bid ){
			$conditions = array_merge($conditions,array('Board.bid'=>$bid));
		}

		$this->unBindModel(array('belongsTo'=>array('User'),'hasMany'=>array('Fileattach')));
		
		$fields = array('BoardCategory.name','Board.category','Board.no','Board.bid','Board.subject','Board.content','Board.total_comment','Board.created');
		if( $bname == TRUE )
		{
			$this->bindModel(array(
				'belongsTo'=>array(
					'BoardSetup' =>
	          array('className'    => 'BoardSetup',
									'conditions'   => '',
									'fields'=>'bname',
									'order'        => '',
									'dependent'    =>  false,
									'foreignKey'   => 'bid',		
						)
					)
				)
			);
			
			array_push($fields,'BoardSetup.bname');
		}					
		$rows = $this->find('all',array(
						'conditions'=>$conditions,
						'fields'=>$fields,
						'limit'=>$limit,
						'order'=>array('Board.created'=>'DESC','Board.sort_no'=>'ASC')
					)
		);
		$data = array();
		foreach($rows as $key=>$row){
			$data[$key] = $row['Board'];
			$data[$key]['bname'] = @$row['BoardSetup']['bname'];			
//			$data[$key]['bid'] = $row['Board'];
			$data[$key]['subject'] = strcut($row['Board']['subject'],$slen);
			$data[$key]['content'] = strcut(str_replace(array('&nbsp;','\n'),'',strip_tags($row['Board']['content'])),$clen);						
			$data[$key]['category'] = @$row['Board']['category'];			
			$data[$key]['categorynm'] = $row['BoardCategory']['name'];
			$data[$key]['link'] = '/board/view/'.$row['Board']['bid'].'/'.$row['Board']['no'].'/category:'.$category;
			$data[$key]['files'] = @$row['Fileattach'];
		}
		return $data;
	}

	/***
	 * 
	 * @return		: int(micro timestemp)
	 */
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	/***
	 * 
	 * @return		: string(table_name)
	 */
	function getTableName(){
		return $this->tablePrefix.$this->table;
	}

	/***
	 * 
	 * @return		: int(no)
	 */
	function createNo()
	{
		$tableName = $this->getTableName();
		$res = $this->query("select max(no) as no from $tableName");

		$no = $res[0][0]['no'];
		if( !$no ){
			$no = 1;
		}else{
			$no = $no + 1;
		}
		return $no;
	}


	/***
	 * 
	 * @param	: string(conditions)
	 * @param	: int(no)
	 * @return		: array(sort_gno,sort_no,sort_depth)
	 */
	function createSort($conditions,$no=null)
	{
		$tableName = $this->getTableName();


		if( $no !== null ){//
		
			$res = $this->query("select sort_no,sort_gno,sort_depth from $tableName where 1 and $conditions and no=$no limit 1");	


			$gno = $res[0][$tableName]['sort_gno'];
			$depth = $res[0][$tableName]['sort_depth'] + 1;

			$sno = doubleval($res[0][$tableName]['sort_no']) + 1;
			
			if( substr($sno,-2) == "00" ) return false;

			$this->query("update $tableName set sort_no=sort_no + 1 where sort_gno=$gno and sort_depth > 0 and sort_no >= $sno and $conditions");

		}else{
			$res = $this->query("select min(sort_no) as sort_no from $tableName where 1 and sort_no > 0 and sort_depth=0 and $conditions");

			$sno = $res[0][0]['sort_no'];

			$depth = 0;
			if( !$sno ){
				$gno = 999999999900;
				$sno = 999999999900;
			   
			}else{

				$sno = (float)$sno - 100;

				$gno = $sno;
			}
		}

		return array($gno,$sno,$depth);
	}

	/***
	 *
	 * @param	: int(no)
	 * @return		: int(sort_no)
	 */
	function getSortArray($no=null){
		if( empty($no) ) return false;
		$data = $this->find(array('no'=>$no),array('sort_no','sort_gno','sort_depth'));
		return $data['Board']; 
	}


	/***
	 *
	 * @param	: int(sort_gno)
	 * @return		: int(sort_no)
	 */
	function getMaxSortNo($sort_gno=null){

		if( empty($sort_gno) ) return false;

		$data = $this->find('first',array(
						'conditions'=>array('sort_gno'=>$sort_gno),
						'fields'=>'sort_no',
						'order'=>array('sort_no'=>'desc'),
						'limit'=>1
				)
		);

		return $data['Board']['sort_no']; 
	}



	/***
	 *
	 * @param	: string(bid)
	 * @param	: int(no)
	 * @param	: string(passwd)
	 * @return		: bool
	 */
	function checkPassword($bid,$no,$passwd){
		$data = $this->find("Board.bid='$bid' and Board.no=$no",array('fields'=>'passwd'));
		if( $data['Board']['passwd'] == $passwd ){
			return true;
		}else{
			return false;
		}
	}


	function updateHit($no){
		$this->updateAll(array('hit'=>'hit+1'),array('no'=>$no));
//		$this->query("update ".$this->tablePrefix.$this->table." set hit=hit+1 where no=$no");
	}


    function save($data,$validate=true){
        return parent::save($data,$validate);
    }
}
?>