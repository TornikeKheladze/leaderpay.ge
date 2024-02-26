import { motion } from "framer-motion";

function Modal({ setClose, children }) {
  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{
        opacity: 1,
        transition: { duration: 0.2 },
      }}
      exit={{
        opacity: 0,
        transition: { duration: 0.2 },
      }}
      className={`modal`}
      onClick={setClose}
    >
      <motion.div
        initial={{ opacity: 0, y: "-150%", x: "-50%" }}
        animate={{
          opacity: 1,
          y: "-50%",
          x: "-50%",
          transition: { duration: 0.2 },
        }}
        exit={{
          opacity: 0,
          y: "-150%",
          transition: { duration: 0.2 },
        }}
        className="modal-content"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="actual-content">{children}</div>
      </motion.div>
    </motion.div>
  );
}

export default Modal;
