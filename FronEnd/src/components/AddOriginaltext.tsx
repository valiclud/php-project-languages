import { useState } from "react";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { addOriginaltext } from "../api/originaltextapi";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogTitle from "@mui/material/DialogTitle";
import type { OriginalText } from "../types/types";

function AddOriginaltext() {
  const [open, setOpen] = useState(false);
  const [originaltext, setOriginaltext] = useState<OriginalText>({
    origtextauthor: "",
    origtexttitle: "",
    origtexttext: "",
    origtextimage: "",
    origtextcentury: 0,
    idplace: 0,
    idlanguage: 0,
    idauthor: 0,
  });
  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };
  // Addoriginaltext.tsx
  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setOriginaltext({
      ...originaltext,
      [event.target.name]: event.target.value,
    });
  };
  const queryClient = useQueryClient();
  const { mutate } = useMutation({
    mutationFn: addOriginaltext,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["originaltexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });
  const handleSave = () => {
    mutate(originaltext);
    setOriginaltext({
      origtextauthor: "",
      origtexttitle: "",
      origtexttext: "",
      origtextimage: "",
      origtextcentury: 0,
      idplace: 0,
      idlanguage: 0,
      idauthor: 0,
    });
    handleClose();
  };
  return (
    <>
      <button onClick={handleClickOpen}>New Original Text</button>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>New Original Text</DialogTitle>
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
        <DialogActions>
          <button onClick={handleClose}>Cancel</button>
          <button onClick={handleSave}>Save</button>
        </DialogActions>
      </Dialog>
    </>
  );
}
export default AddOriginaltext;
