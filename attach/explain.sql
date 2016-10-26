
#########  统计查询   #######

select 
	sum(reply_count) as reply_count , sum(view_count) view_count, 
	count(post_id) post_count , min(create_time) begin_time 
from tbl_post 
WHERE `status_is` = 'Y' AND `is_deleted` = '0';
# [ RunTime:1.9390s ]



SELECT COUNT(*) AS tp_count FROM `tbl_post` WHERE `is_deleted` = 0 AND `status_is` = 'Y' LIMIT 1 ;
# [ RunTime: 16.07 sec ]




SELECT COUNT(post_id) AS tp_count FROM `tbl_post` WHERE `is_deleted` = 0 AND `status_is` = 'Y' LIMIT 1 ;
# [ RunTime: 15.87 sec ]







################ 连接查询 ####################
SELECT 
	Post.post_id AS post_id,Post.title AS title,Post.create_time AS create_time,
	Post.cate_id AS cate_id,Post.content AS content,Post.view_count AS view_count,Post.tags AS tags,
	Post.reply_count AS reply_count,Post.is_deleted AS is_deleted,Post.status_is AS status_is,
	Post.sort_order AS sort_order,Cate.cate_name AS cate_name
FROM tbl_post Post JOIN tbl_cate Cate ON Post.cate_id=Cate.id 
WHERE Post.is_deleted = 0 AND Post.status_is = 'Y'
ORDER BY `sort_order` DESC,`post_id` ASC 
LIMIT 240,40;
# [ RunTime: 16.69 sec ]

























