import CountUp from "react-countup";
import { useInView } from "react-intersection-observer";

const Counter = ({ end }) => {
  const [inViewRef, inView] = useInView({
    triggerOnce: true, // This ensures it only triggers once
    threshold: 0.5, // Change this threshold as needed
  });

  return <div ref={inViewRef}>{inView && <CountUp end={end} />}</div>;
};

export default Counter;
