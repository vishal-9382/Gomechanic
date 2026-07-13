<?php
require './database.php';
$disst=$_POST['type'];
$option=null;
				$query="SELECT * FROM city_area WHERE area_city='$type' ";
							$results=mysqli_query($connection,$query);
								if($results){
									if(mysqli_num_rows($results)>0){
									while($row = mysqli_fetch_object($results))
									{
										$constid = $row->type_id;
										$constname = $row->type_name;
										echo '<option value="'.$constid.'">'.$constname.'</option>';
							}
						}
					}
					else{echo mysqli_error($connection);}
 //echo $option;
 ?>