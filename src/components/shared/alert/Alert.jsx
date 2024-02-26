import { AnimatePresence, motion } from "framer-motion";

const Alert = ({ messageObj }) => {
  return (
    <>i
      <AnimatePresence>
        {messageObj && (
          <motion.div
            initial={{ opacity: 0, x: 500 }}
            animate={{ opacity: 1, x: 0, transition: { duration: 0.2 } }}
            exit={{ opacity: 0, x: 500, transition: { duration: 0.2 } }}
            className={`alert ${
              messageObj.type === "success" ? "bg-success " : "bg-error"
            }`}
          >
            {messageObj?.message}
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
};

export default Alert;
