<?php

namespace Model;

use Lib\Manager;

class BlogManager extends Manager
{
    public function setLimit()
    {
        $nodes = $this->config->getElementsByTagName('postsperpage');
        foreach ($nodes as $node) {
            if ($node->getAttribute('page') == 'blog') {
                $this->limit = intval($node->getAttribute('limit'));
            }
        }
    }

    public function processCommentForm()
    {
        if ($_POST['csrf_token'] == $_SESSION['token']) {
            if (!empty($_POST['pseudo'])) {
                $pseudo = htmlspecialchars($_POST['pseudo']);
            } else {
                $pseudo = 'A.Nonymous';
            }

            if (!empty($_POST['email'])) {
                $mail = htmlspecialchars($_POST['email']);
            } else {
                $mail = "email@example.com";
            }

            $gHash = md5(strtolower(trim($mail)));
            $comment = htmlspecialchars($_POST['comment']);
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $postId = $_POST['postId'];

            $query = $this->dao->prepare('INSERT INTO blog_comments (pseudo, mailAdress, gHash, comment, commentDate, postId) VALUES (:pseudo, :mailAdress, :gHash, :comment, :commentDate, :postId)');
            $query->bindParam(':pseudo', $pseudo, \PDO::PARAM_STR);
            $query->bindParam(':mailAdress', $mail, \PDO::PARAM_STR);
            $query->bindParam(':gHash', $gHash, \PDO::PARAM_STR);
            $query->bindParam(':comment', $comment, \PDO::PARAM_STR);
            $query->bindParam(':commentDate', $date);
            $query->bindParam(':postId', $postId, \PDO::PARAM_INT);

            $query->execute();

            $update = $this->dao->prepare('UPDATE blog_posts SET nbComment = nbComment+1 WHERE id = :id');
            $update->bindParam(':id', $_POST['postId'], \PDO::PARAM_INT);
            $update->execute();
        }
    }
}
