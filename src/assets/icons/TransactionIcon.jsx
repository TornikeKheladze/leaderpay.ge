const TransactionIcon = () => {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="42px"
      height="42px"
      style={{
        marginRight: "20px",
      }}
      viewBox="0 0 24 24"
      className={`arrow-icon `}
    >
      <path
        fill="none"
        stroke="#ee6c20"
        strokeWidth="2"
        d="M2,7 L20,7 M16,2 L21,7 L16,12 M22,17 L4,17 M8,12 L3,17 L8,22"
      />
    </svg>
  );
};

export default TransactionIcon;
