import DialogContent from "@mui/material/DialogContent";
import type { OriginalText } from "../types/types";
import TextField from "@mui/material/TextField";
import Stack from "@mui/material/Stack";
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
      <Stack spacing={1.5} mt={1}>
        <TextField
          label="Author"
          name="origtextauthor"
          value={originaltext.origtextauthor}
          onChange={handleChange}
        />
        <TextField
          label="Title"
          name="origtexttitle"
          value={originaltext.origtexttitle}
          onChange={handleChange}
        />
        <TextField
          label="Text"
          name="origtexttext"
          value={originaltext.origtexttext}
          onChange={handleChange}
        />
        <TextField
          label="Image"
          name="origtextimage"
          value={originaltext.origtextimage}
          onChange={handleChange}
        />
        <TextField
          label="Century"
          name="origtextcentury"
          value={originaltext.origtextcentury}
          onChange={handleChange}
        />
        <TextField
          label="Place Id"
          name="idplace"
          value={originaltext.idplace}
          onChange={handleChange}
        />
        <TextField
          label="Old Language Id"
          name="idlanguage"
          value={originaltext.idlanguage}
          onChange={handleChange}
        />
        <TextField
          label="Author Id"
          name="idauthor"
          value={originaltext.idauthor}
          onChange={handleChange}
        />
      </Stack>
    </DialogContent>
  );
}
export default OriginaltextDialogContent;
