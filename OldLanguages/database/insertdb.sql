SET FOREIGN_KEY_CHECKS=0;
INSERT INTO old_language (id,language,period)
VALUES (1 /*not nullable*/,'Armaiac' /*not nullable*/,'light' /*not nullable*/);
INSERT INTO old_language (id,language,period)
VALUES (2 /*not nullable*/,'Ancient Greek' /*not nullable*/,'light' /*not nullable*/);
INSERT INTO old_language (id,language,period)
VALUES (3 /*not nullable*/,'Egyptian' /*not nullable*/,'light' /*not nullable*/);
INSERT INTO old_language (id,language,period)
VALUES (4 /*not nullable*/,'Egyptian Kopt' /*not nullable*/,'light' /*not nullable*/);

INSERT INTO original_text (id,author,title,text,text_img,century,insert_date,hits,place_id,old_language_id)
<<<<<<< Updated upstream
VALUES (2 /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/,'s',0 /*not nullable*/,{d '2023-12-04'} /*not nullable*/,0 /*not nullable*/,1 /*not nullable*/,1 /*not nullable*/);

INSERT INTO place (id,place,country) 
VALUES (2 /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/);

INSERT INTO translated_text (id,author,title,text,language,insert_date,revision,original_text_id) 
VALUES (2 /*not nullable*/,'s','s','s','s',{d '2023-12-04'},0,1 /*not nullable*/);

INSERT INTO pagination (id,controller_name,results)
VALUES ( 1/*not nullable*/,'translatedtextController' /*not nullable*/,3 /*not nullable*/);
VALUES ( 2/*not nullable*/,'originaltextController' /*not nullable*/,4 /*not nullable*/);

SET FOREIGN_KEY_CHECKS=1;

=======
VALUES (1 /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/,'s' /*not nullable*/,'s',0 /*not nullable*/,{d '2023-12-04'} /*not nullable*/,0 /*not nullable*/,1 /*not nullable*/,1 /*not nullable*/);
INSERT INTO original_text (id,author,title,text,text_img,century,insert_date,hits,place_id,old_language_id)
VALUES (4 /*not nullable*/,'t' /*not nullable*/,'t' /*not nullable*/,'s' /*not nullable*/,'t',0 /*not nullable*/,{d '2023-12-04'} /*not nullable*/,0 /*not nullable*/,2 /*not nullable*/,2 /*not nullable*/);
INSERT INTO original_text (id,author,title,text,text_img,century,insert_date,hits,place_id,old_language_id)
VALUES (7 /*not nullable*/,'u' /*not nullable*/,'u' /*not nullable*/,'u' /*not nullable*/,'s',0 /*not nullable*/,{d '2023-12-04'} /*not nullable*/,0 /*not nullable*/,3 /*not nullable*/,3 /*not nullable*/);

INSERT INTO place (id,place,country)
VALUES (1 /*not nullable*/,'Alexandria' /*not nullable*/,'Egypt' /*not nullable*/);
INSERT INTO place (id,place,country)
VALUES (2 /*not nullable*/,'Cyprus' /*not nullable*/,'Greek' /*not nullable*/);
INSERT INTO place (id,place,country)
VALUES (3 /*not nullable*/,'Athens' /*not nullable*/,'Greek' /*not nullable*/);


INSERT INTO translated_text (id,author,title,text,language,insert_date,revision,original_text_id)
VALUES (1 /*not nullable*/,'s','s','s','s',{d '2023-12-04'},0,1 /*not nullable*/);
INSERT INTO translated_text (id,author,title,text,language,insert_date,revision,original_text_id)
VALUES (4 /*not nullable*/,'tt','tt','tt','s',{d '2023-12-04'},0,2 /*not nullable*/);
SET FOREIGN_KEY_CHECKS=1;
>>>>>>> Stashed changes
