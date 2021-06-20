<?php
declare(strict_types=1);

namespace EngineWorks\ProgressStatus\Tests;

use EngineWorks\ProgressStatus\ObserversSet;
use PHPUnit\Framework\TestCase;
use EngineWorks\ProgressStatus\Tests\Mocks\Observer;

class ObserversSetTest extends TestCase
{
    public function testConstructor()
    {
        $observers = new ObserversSet();
        $this->assertInstanceOf(\Countable::class, $observers);
        $this->assertInstanceOf(\Iterator::class, $observers);
        $this->assertCount(0, $observers);
    }

    public function testAttatchDetach()
    {
        $observer = new Observer();
        $observers = new ObserversSet();

        $observers->attach($observer);
        $this->assertCount(1, $observers);

        // double attach
        $observers->attach($observer);
        $this->assertCount(1, $observers);

        // second attach
        $observers->attach(new Observer());
        $this->assertCount(2, $observers);

        // detach attach
        $observers->detach($observer);
        $this->assertCount(1, $observers);
    }

    public function testIterator()
    {
        // populate
        $count = 5;
        $observers = new ObserversSet();
        for ($i = 0; $i < $count; $i++) {
            $observers->attach(new Observer());
        }
        $this->assertCount($count, $observers);

        // retrieve using iterator
        $elements = 0;
        foreach ($observers as $key => $observer) {
            $this->assertEquals($elements, $key);
            $this->assertInstanceOf(\SplObserver::class, $observer);
            $elements = $elements + 1;
        }
        $this->assertSame($count, $elements);
    }
}
