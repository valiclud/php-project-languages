import { BrowserRouter, Routes, Route, Link } from "react-router-dom";
import Translatedtextlist from "../components/Translatedtextlist";
import Originaltextlist from "../components/Originaltextlist";

function MainRoute() {
  return (
    <BrowserRouter>
      <nav>
        <Link to="/">Home</Link>
        {" | "}
        <Link to="/translatedtext/list">Translated Texts</Link>
        {" | "}
        <Link to="/originaltext/list">Original Texts</Link>
      </nav>
      <Routes>
        <Route path="/" element={<h1>Home</h1>} />
        <Route path="/translatedtext/list" element={<Translatedtextlist />} />
        <Route path="/originaltext/list" element={<Originaltextlist />} />
      </Routes>
    </BrowserRouter>
  );
}
export default MainRoute;
