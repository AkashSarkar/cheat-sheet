const fruits = {
  apple: 28,
  orange: 17,
  pear: 54,
}

const keys = Object.keys(fruits)
console.log(keys) // [apple, orange, pear]


const fruits = {
  apple: 28,
  orange: 17,
  pear: 54,
}

const values = Object.values(fruits)
console.log(values) // [28, 17, 54]


const fruits = {
  apple: 28,
  orange: 17,
  pear: 54,
}

const entries = Object.entries(fruits)
console.log(entries)
// [
//   [apple, 28],
//   [orange, 17],
//   [pear, 54]
// ]


 Object.entries(data).forEach(([key, value]) => {
                totalItems += value.amount;
            });



