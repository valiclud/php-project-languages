import DialogContent from "@mui/material/DialogContent";
import type { TranslatedText } from "../types/types";
import TextField from "@mui/material/TextField";
import Stack from "@mui/material/Stack";
type DialogFormProps = {
  translatedtext: TranslatedText;
  handleChange: (event: React.ChangeEvent<HTMLInputElement>) => void;
};
function TranslatedtextDialogContent({
  translatedtext,
  handleChange,
}: DialogFormProps) {
  return (
    <DialogContent>
      <Stack spacing={1.5} mt={1}>
        <TextField
          label="Title"
          name="transtexttitle"
          value={translatedtext.transtexttitle}
          onChange={handleChange}
        />
        <TextField
          label="Text"
          name="transtexttext"
          value={translatedtext.transtexttext}
          onChange={handleChange}
        />
        <TextField
          label="Language"
          name="transtextlanguage"
          value={translatedtext.transtextlanguage}
          onChange={handleChange}
        />
        <TextField
          label="Revision"
          name="revision"
          value={translatedtext.revision}
          onChange={handleChange}
        />
        <TextField
          label="Author Id"
          name="idauthor"
          value={translatedtext.idauthor}
          onChange={handleChange}
        />
        <TextField
          label="Orig Text Id"
          name="idorigtext"
          value={translatedtext.idorigtext}
          onChange={handleChange}
        />
      </Stack>
    </DialogContent>
  );
}
export default TranslatedtextDialogContent;
