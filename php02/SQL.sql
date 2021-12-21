INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES(:name, :email, :naiyou, :indate,sysdate()); -- :変数名,（バインド変数）,sqlの表のセルと連携する

INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES('テスト２','test01@test.jp','内容１',sysdate());
INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES('テスト３','test01@test.jp','内容１',sysdate());
INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES('テスト４','test01@test.jp','内容１',sysdate());
INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES('テスト５','test01@test.jp','内容１',sysdate());
INSERT INTO gs_an_table(name,email,naiyou,indate)VALUES('テスト６','test01@test.jp','内容１',sysdate());

SELECT * FROM gs_an_table WHERE id=2;

SELECT * FROM gs_an_table WHERE id>=2;

-- and orで条件指定
SELECT * FROM gs_an_table WHERE id=1 OR id=3;
SELECT * FROM gs_an_table WHERE id=1 OR id=10;
SELECT * FROM gs_an_table WHERE id>=1 AND id<=3;

SELECT * FROM gs_an_table WHERE email LIKE '%1%';

SELECT * FROM gs_an_table ORDER BY id DESC;

SELECT * FROM gs_an_table ORDER BY id DESC LIMIT 3;