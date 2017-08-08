<?php
// Dernière modification : Mardi 08 août[08] 2017

declare( strict_types = 1 );

use PHPUnit\Framework\TestCase;

/**
 * @author PIVARD Julien
 * */
class JoueursTest extends TestCase
{

    public function testChangerId() : void
    {
        $j = new Joueur();
        $id = rand( 1, 100 );
        $j->set_id( $id );
        $this->assertEquals( $id, $j->get_id() );
    }

}
