import math from './math'

const { sum }= math()

test('somar dois números', () => {
    expect(sum(1,2)).toBe(3);
})