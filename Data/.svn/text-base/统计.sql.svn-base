
update cms_resource set filename = replace(filename,'|','|http://125.171.0.175:8080') , filename192 = replace(filename192,'|','|http://125.171.0.175:8080') , songphoto='http://125.171.0.175:8080'||songphoto;
update cms_article set image = 'http://125.171.0.175:8080'||image where image is not null;
update cms_magazine set mphoto = 'http://125.171.0.175:8080'||mphoto where mphoto is not null;



select  substr(request_uri,length(request_uri)-16,12) as code,substr(request_uri,length(request_uri)-16,13) as music,request_uri,count(request_uri) from  sys_log  where request_uri like '%.mp3%' group by request_uri,CREATE_BY;


select m.*,f.isshare from cms_magazine  m left  join cms_favorites f on m.mid=f.sourceid;

select * from cms_resource where instr(filename,'125.171.0.175:8080')<=0

update cms_resource cr set cr.THUMBNAIL_URL = (select THUMBNAIL_URL from cms_file cf where cf.url = cr.SONGPHOTO and rownum=1);


select  a.id,a.songname,a.songer,b.bnum,c.fnum,d.snum from cms_resource a left join (  select resourceid,count(num) as bnum from cms_musichit where 1=1 group by resourceid) b on a.id =b.resourceid
left join ( select sourceid,count(sourceid) as fnum from CMS_FAVORITES where sourcetype='0' and isshare in ('0','2') group by sourceid) c on a.id = c.sourceid
left join ( select sourceid,count(sourceid) as snum from CMS_FAVORITES where sourcetype='0' and isshare in ('1','2') group by sourceid) d on a.id = d.sourceid;


update cms_resource set filename = replace(filename,'files.wawa.fm','fast.wawa.fm') , filename192 = replace(filename192,'files.wawa.fm','fast.wawa.fm') , songphoto = replace(songphoto,'files.wawa.fm','fast.wawa.fm'),thumbnail_url = replace(thumbnail_url,'files.wawa.fm','fast.wawa.fm');

update cms_magazine set mphoto = replace(mphoto,'files.wawa.fm','fast.wawa.fm'), thumbnail_url = replace(thumbnail_url,'files.wawa.fm','fast.wawa.fm')  ;

update sys_user_detail set pimg = replace(pimg,'files.wawa.fm','fast.wawa.fm');

update cms_favorites set thumbnail_url = replace(thumbnail_url,'files.wawa.fm','fast.wawa.fm'),fphoto = replace(fphoto,'files.wawa.fm','fast.wawa.fm');

update cms_article set image = replace(image,'files.wawa.fm','fast.wawa.fm') ;

update cms_article_data set content = replace(content,'files.wawa.fm','fast.wawa.fm'),musicfile = replace(musicfile,'files.wawa.fm','fast.wawa.fm'),imagefile = replace(imagefile,'files.wawa.fm','fast.wawa.fm');

update sys_dict set url = replace(url,'files.wawa.fm','fast.wawa.fm') ;

update cms_version set url = replace(url,'files.wawa.fm','fast.wawa.fm') ;

update cms_file set url = replace(url,'files.wawa.fm','fast.wawa.fm'), thumbnail_url = replace(thumbnail_url,'files.wawa.fm','fast.wawa.fm')  ;

update cms_welcome set adphoto = replace(adphoto,'files.wawa.fm','fast.wawa.fm') ;


update wa_document set cover_url = replace(cover_url,'119.29.66.49','fast.wawa.fm') ;
update wa_document_app set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_document_wenyi set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_document_youpin set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_document_yueren set content = replace(content,'119.29.66.49','fast.wawa.fm'),adimg = replace(adimg,'119.29.66.49','fast.wawa.fm'),codepic = replace(codepic,'119.29.66.49','fast.wawa.fm')  ;
update wa_ucenter_member set pimg = replace(pimg,'119.29.66.49','fast.wawa.fm'),card = replace(card,'119.29.66.49','fast.wawa.fm') ;
update wa_member set pimg = replace(pimg,'119.29.66.49','fast.wawa.fm'),card = replace(card,'119.29.66.49','fast.wawa.fm')  ;




