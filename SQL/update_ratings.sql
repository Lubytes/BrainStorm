DELIMITER $$
DROP TRIGGER IF EXISTS update_ratings$$
CREATE TRIGGER update_ratings
AFTER INSERT ON ratings
FOR EACH ROW
BEGIN

	/* get the total rating of the attraction */
    
    UPDATE posts 
    SET posts.rating = (SELECT SUM(ratings.value) 
		FROM ratings WHERE ratings.post_ID = posts.post_ID)     
    WHERE posts.post_ID = NEW.post_ID; 
    
END$$
DELIMITER ;