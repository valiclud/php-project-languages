import DialogContent from "@mui/material/DialogContent";
import type { OriginalText } from "../types/types";
type DialogFormProps = {
  originaltext: OriginalText;
  handleChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
};
function OriginaltextDialogContent({
  originaltext,
  handleChange,
}: DialogFormProps) {
  return (
    <DialogContent>
      <input
        placeholder="Author"
        name="origtextauthor"
        value={originaltext.origtextauthor}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Title"
        name="origtexttitle"
        value={originaltext.origtexttitle}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Text"
        name="origtexttext"
        value={originaltext.origtexttext}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Image"
        name="origtextimage"
        value={originaltext.origtextimage}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Century"
        name="origtextcentury"
        value={originaltext.origtextcentury}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Place Id"
        name="idplace"
        value={originaltext.idplace}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Old Language Id"
        name="idlanguage"
        value={originaltext.idlanguage}
        onChange={handleChange}
      />
      <br />
      <input
        placeholder="Author Id"
        name="idauthor"
        value={originaltext.idauthor}
        onChange={handleChange}
      />
      <br />
    </DialogContent>
  );
}
export default OriginaltextDialogContent;
