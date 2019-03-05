<?php
use PHPUnit\Framework\TestCase;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TicketTest
 *
 * @author tschroefel
 */
class TicketTest extends TestCase
{
    //put your code here
    public function testCreate()
    {
        $ticket = new Ticket();
        $ticket->Title = "My test ticket";
        $id = $ticket->Save();
        $ticket->Read($id, false);
        $this->assertSame("My test ticket",$ticket->Title);
    }
}
