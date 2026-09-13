import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogTitle from "@mui/material/DialogTitle";
import { useState, type ChangeEvent } from "react";
import OriginaltextDialogContent from "./OriginaltextDialogContent";
import { type OriginalText, type OriginalTextResponse } from "../types/types";

type FormProps = {
  originaltextdata: OriginalTextResponse;
};

function EditOriginaltext({ originaltextdata }: FormProps) {
  const [open, setOpen] = useState(false);

  const [originaltext, setOriginalText] = useState<OriginalText>({
    origtextauthor: originaltextdata.origtextauthor,
    origtexttitle: originaltextdata.origtexttitle,
    origtexttext: originaltextdata.origtexttext,
    origtextimage: originaltextdata.origtextimage,
    origtextcentury: originaltextdata.origtextcentury,
    idplace: originaltextdata.idplace,
    idlanguage: originaltextdata.idlanguage,
    idauthor: originaltextdata.idauthor,
  });

  const handleClickOpen = () => {
    setOriginalText({
      origtextauthor: originaltextdata.origtextauthor,
      origtexttitle: originaltextdata.origtexttitle,
      origtexttext: originaltextdata.origtexttext,
      origtextimage: originaltextdata.origtextimage,
      origtextcentury: originaltextdata.origtextcentury,
      idplace: originaltextdata.idplace,
      idlanguage: originaltextdata.idlanguage,
      idauthor: originaltextdata.idauthor,
    });
    setOpen(true);
  };

  const handleChange = (event: ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setOriginalText({
      ...originaltext,
      [name]:
        name === "origtextcentury" ||
        name === "idplace" ||
        name === "idlanguage" ||
        name === "idauthor"
          ? Number(value)
          : value,
    });
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleSave = () => {
    setOpen(false);
  };

  return (
    <>
      <button onClick={handleClickOpen}>Edit</button>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>Edit Original Text</DialogTitle>
        <OriginaltextDialogContent
          originaltext={originaltext}
          handleChange={handleChange}
        />
        <DialogActions>
          <button onClick={handleClose}>Cancel</button>
          <button onClick={handleSave}>Save</button>
        </DialogActions>
      </Dialog>
    </>
  );
}

export default EditOriginaltext;
