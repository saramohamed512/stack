<?php
ini_set('memory_limit', '2G');

class Stack
{
    protected array $stack = [];
    protected array $maxStack = [];
    protected int $sum = 0; 

    public function push(int $number): void
    {
        if (!is_int($number) || $number < 0) {
            throw new InvalidArgumentException("Only unsigned integers are allowed");
        }
        $this->stack[] = $number;
        $this->sum += $number;

        if (empty($this->maxStack) || $number >= end($this->maxStack)) {
            $this->maxStack[] = $number;
        }
    }

   
    public function pop(): ?int
    {
        if (empty($this->stack)) {
            return null;
        }

        $poppedValue = array_pop($this->stack);
        $this->sum -= $poppedValue;

        if ($poppedValue === end($this->maxStack)) {
            array_pop($this->maxStack);
        }

        return $poppedValue;
    }

    public function max(): ?int
    {
        return empty($this->maxStack) ? null : end($this->maxStack);
    }

}

class Extras extends Stack
{
    
    public function mean(): ?float
    {
        $count =count($this->stack);
        return $count === 0 ? null : $this->sum / $count;
    }
}

function testSmallDataset() {
    $stack = new Extras();

    echo "[Test 1] Small Dataset Functional Test\n";

    $stack->push(10);
    $stack->push(20);
    $stack->push(30);

    echo "Max: " . $stack->max() . "\n"; // Output: 30
    echo "Mean: " . $stack->mean() . "\n"; // Output: 20

    echo "Popped: " . $stack->pop() . "\n"; // Output: 30
    echo "Max after pop: " . $stack->max() . "\n"; // Output: 20
    echo "Mean after pop: " . $stack->mean() . "\n\n"; // Output: 15
}

/**Why is this Solution Fast?
*Using pre-calculated data makes this solution fast: maxStack enables O(1) max operations, and the pre-computed sum allows O(1) mean calculations, avoiding unnecessary recalculations.
*/

function testLargeDataset() {
    $stack = new Extras();

    echo "[Test 2] Large Dataset Performance Test\n";

    $startTime = microtime(true);

    for ($i = 1; $i <= 10000000; $i++) {
        $stack->push($i);
    }

    $endTime = microtime(true);
    echo "Pushing 10 million numbers in " . ($endTime - $startTime) . " sec.\n";

    
    $startTime = microtime(true);
    $maxValue = $stack->max();
    $endTime = microtime(true);
    echo "Max: $maxValue in " . ($endTime - $startTime) . " sec.\n";

  
    $startTime = microtime(true);
    $meanValue = $stack->mean();
    $endTime = microtime(true);
    echo "Mean: $meanValue in " . ($endTime - $startTime) . " sec.\n";

    $startTime = microtime(true);

    for ($i = 0; $i < 1000000; $i++) {
        $stack->pop();
    }

    $endTime = microtime(true);
    echo "Popping 1 million numbers in " . ($endTime - $startTime) . " sec.\n";

    echo "Max after pop: " . $stack->max() . "\n";
    echo "Mean after pop: " . $stack->mean() . "\n\n";
}

// Run the tests
testSmallDataset();
testLargeDataset();

/**Why is this Solution Fast?
*Using pre-calculated data makes this solution fast: maxStack enables O(1) max operations, and the pre-computed sum allows O(1) mean calculations, avoiding unnecessary recalculations.
*/


