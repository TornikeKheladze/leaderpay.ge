export const arraySplitter = (arr) => {
  const middleIndex = Math.floor(arr.length / 2);
  const firstArray = arr.slice(0, middleIndex + (arr.length % 2));
  const secondArray = arr.slice(middleIndex + (arr.length % 2));

  return [firstArray, secondArray];
};
