<?php
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_connector.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/create_statement.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/db_ini_insert.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/create_procedure.php";
include $_SERVER['DOCUMENT_ROOT']."/helf/common/lib/create_trigger.php";

create_table($conn, 'members');
create_table($conn, 'message');
create_table($conn, 'program');
create_table($conn, 'sales');
create_table($conn, 'p_review');
create_table($conn, 'p_qna');
create_table($conn, 'notice');
create_table($conn, 'faq');
create_table($conn, 'community');
create_table($conn, 'comment');
create_table($conn, 'health_info');
create_table($conn, 'together');
create_table($conn, 'carecenter');
create_table($conn, 'pick');
create_table($conn, 'cart');
create_table($conn, 'rating_health_info');
create_table($conn, 'rating_together_info');
create_table($conn, 'rating_community_info');
create_table($conn, 'deleted_members');

insert_init_data($conn, 'members');
insert_init_data($conn, 'program');
insert_init_data($conn, 'p_review');
insert_init_data($conn, 'p_qna');
insert_init_data($conn, 'notice');
insert_init_data($conn, 'faq');
insert_init_data($conn, 'comment');
insert_init_data($conn, 'community');
insert_init_data($conn, 'health_info');
insert_init_data($conn, 'together');

create_procedure($conn, 'carecenter_procedure');
create_trigger($conn);  //deleted_members

?>
