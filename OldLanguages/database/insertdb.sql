SET FOREIGN_KEY_CHECKS=0;
INSERT INTO old_language (id,old_language,period) 
VALUES (2 /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/);

INSERT INTO original_text (id,author,title,text,text_img,century,insert_date,hits,place_id,old_language_id)
VALUES (2 /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/,'s',0 /*not nullable*/,{d '2023-12-04'} /*not nullable*/,0 /*not nullable*/,1 /*not nullable*/,1 /*not nullable*/);



INSERT INTO place (id,place,country) 
VALUES (2 /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/);


INSERT INTO translated_text (id,author,title,text,language,insert_date,revision,original_text_id) 
VALUES (2 /*not nullable*/,'s','s','s','s',{d '2023-12-04'},0,1 /*not nullable*/);
SET FOREIGN_KEY_CHECKS=1;