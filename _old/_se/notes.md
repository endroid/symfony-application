# Notes

## General

* WSSE Bundle maken of bestaande gebruiken
* Use Roboto font
* Uitzoeken of functionele tests gemakkelijker kunnen voor SF bundles (check kernelawarecontext)
* Functionele tests over bundles gelijktrekken
* User login: redirect admin / front end / api afhankelijk van type user: verschil tussen hasRole / isGranted?
* Translations: overal keys i.p.v. vertaalde labels
* Open Graph: decent implementation
* Word generator bundle (or ExportBundle / implementation example): o.b.v. werkzaamheden Nauta TRS
* Uploader + image field bij nieuws
* Elasticsearch: update > 1.5.2 (watching)
* Elasticsearch: gebruik index en array result i.p.v. finder
* Gebruiken configureTabMenu in sonata admin voor meertaligheid
* Sonata Admin Extensions: "uses" toepassen: https://sonata-project.org/bundles/admin/master/doc/reference/extensions.html ipv interface
* Library voor orderedinterface etc. (verplaatsen behaviors naar aparte bundles?)

## Simple Excel

Conventions:
* Gebruik zoveel mogelijk bestaande convertors
  bijv. path => array
  
## Conversiebibliotheek  
  
* Bij tussenstap altijd naar representatie met meeste opties
  bijv. phpexcel ondersteunt wel cell coloring, array niet
* Auto wiring: a => b en b => c, dus a => c is mogelijk



<?php
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FooController
{
    /**
     * @Security("is_granted('CAN_SEE_POST', post)")
     */
    public function fooAction(Post $post)
    {
        // ...
    }
}


<?php
namespace App\Security\Voter;

use App\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EditPostVoter extends Voter
{    
    protected function supports($attribute, $subject)
    {
        // you only want to vote if the attribute and subject are what you expect
        return $attribute === 'CAN_EDIT_POST' && $subject instanceof Post;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // our previous business logic indicates that mods and admins can do it regardless
        foreach ($token->getRoles() as $role) {
            if (in_array($role->getRole(), ['ROLE_MODERATOR', 'ROLE_ADMIN'])) {
                return true;
            }
        }   

        /** @var $subject Post */
        return $subject->getOwner()->getId() === $token->getUsername() && !$subject->isLocked();
    }
}